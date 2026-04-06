<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\ServerMetric;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MetricController extends Controller
{
    private const PAYLOAD_EXPIRY_SECONDS = 300;

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|string',
            'payload' => 'sometimes|string',
            'signature' => 'sometimes|string',
            'timestamp' => 'sometimes|integer',
            'cpu' => 'required_without:payload|numeric|min:0|max:100',
            'ram' => 'required_without:payload|numeric|min:0|max:100',
            'disk' => 'required_without:payload|numeric|min:0|max:100',
            'network_in' => 'required_without:payload|numeric|min:0',
            'network_out' => 'required_without:payload|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $server = Server::where('api_token', $request->api_token)->first();

        if (!$server) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        if ($request->filled('payload') && $request->filled('signature') && $request->filled('timestamp')) {
            if (!$this->verifySignedPayload($request, $server)) {
                return response()->json(['error' => 'Invalid signature or expired payload'], 401);
            }
            $data = json_decode($request->payload, true);
        } else {
            $data = $request->only(['cpu', 'ram', 'disk', 'network_in', 'network_out']);
        }

        $metric = ServerMetric::create([
            'server_id' => $server->id,
            'cpu_usage' => $data['cpu'],
            'ram_usage' => $data['ram'],
            'disk_usage' => $data['disk'],
            'network_in' => $data['network_in'],
            'network_out' => $data['network_out'],
        ]);

        return response()->json([
            'message' => 'Metrics received successfully',
            'metric_id' => $metric->id
        ], 201);
    }

    private function verifySignedPayload(Request $request, Server $server): bool
    {
        $timestamp = $request->integer('timestamp');
        $now = time();

        if (abs($now - $timestamp) > self::PAYLOAD_EXPIRY_SECONDS) {
            return false;
        }

        $payload = $request->payload;
        $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $payload, $server->api_token);

        return hash_equals($expectedSignature, $request->signature);
    }

    public function generateSignedPayload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|string',
            'cpu' => 'required|numeric|min:0|max:100',
            'ram' => 'required|numeric|min:0|max:100',
            'disk' => 'required|numeric|min:0|max:100',
            'network_in' => 'required|numeric|min:0',
            'network_out' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $server = Server::where('api_token', $request->api_token)->first();

        if (!$server) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        $payload = json_encode($request->only(['cpu', 'ram', 'disk', 'network_in', 'network_out']));
        $timestamp = time();
        $signature = hash_hmac('sha256', $timestamp . '.' . $payload, $server->api_token);

        return response()->json([
            'payload' => $payload,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);
    }
}