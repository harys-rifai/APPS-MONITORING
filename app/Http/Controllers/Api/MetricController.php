<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\ServerMetric;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class MetricController extends Controller
{
    public function store(Request $request): JsonResponse
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

        $metric = ServerMetric::create([
            'server_id' => $server->id,
            'cpu_usage' => $request->cpu,
            'ram_usage' => $request->ram,
            'disk_usage' => $request->disk,
            'network_in' => $request->network_in,
            'network_out' => $request->network_out,
        ]);

        return response()->json([
            'message' => 'Metrics received successfully',
            'metric_id' => $metric->id
        ], 201);
    }
}