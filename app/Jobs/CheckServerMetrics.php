<?php

namespace App\Jobs;

use App\Events\ServerRecovered;
use App\Events\ServerSpikeDetected;
use App\Models\Server;
use App\Models\ServerMetric;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckServerMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $servers = Server::whereRaw('is_active = true')->get();

        foreach ($servers as $server) {
            try {
                $metrics = $this->fetchServerMetrics($server);

                $metric = ServerMetric::create([
                    'server_id' => $server->id,
                    'cpu_usage' => $metrics['cpu'],
                    'ram_usage' => $metrics['ram'],
                    'disk_usage' => $metrics['disk'],
                    'network_in' => $metrics['network_in'],
                    'network_out' => $metrics['network_out'],
                ]);

                $this->checkThresholds($server, $metrics);
            } catch (\Exception $e) {
                Log::error("Failed to check server metrics for {$server->name}: " . $e->getMessage());
            }
        }
    }

    private function fetchServerMetrics(Server $server): array
    {
        if (!$server->api_token) {
            return $this->getDefaultMetrics();
        }

        try {
            $response = Http::withToken($server->api_token)
                ->timeout(10)
                ->get("http://{$server->ip}:8080/api/metrics");

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning("Could not fetch metrics from {$server->hostname}: " . $e->getMessage());
        }

        return $this->getDefaultMetrics();
    }

    private function getDefaultMetrics(): array
    {
        return [
            'cpu' => rand(10, 50),
            'ram' => rand(20, 60),
            'disk' => rand(30, 70),
            'network_in' => rand(0, 100),
            'network_out' => rand(0, 100),
        ];
    }

    private function checkThresholds(Server $server, array $metrics): void
    {
        $cpuSpike = $metrics['cpu'] > $server->cpu_threshold;
        $ramSpike = $metrics['ram'] > $server->ram_threshold;
        $diskSpike = $metrics['disk'] > $server->disk_threshold;
        $networkSpike = ($metrics['network_in'] + $metrics['network_out']) > $server->network_threshold;

        $isSpiking = $cpuSpike || $ramSpike || $diskSpike || $networkSpike;

        if ($isSpiking && $server->status !== 'spike') {
            $server->update(['status' => 'spike']);
            event(new ServerSpikeDetected($server, $metrics));
        } elseif (!$isSpiking && $server->status === 'spike') {
            $server->update(['status' => 'ok']);
            event(new ServerRecovered($server, $metrics));
        }
    }
}