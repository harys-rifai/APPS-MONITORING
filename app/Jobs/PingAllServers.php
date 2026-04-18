<?php

namespace App\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PingAllServers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $servers = Server::whereRaw('is_active = true')->get();

        foreach ($servers as $server) {
            $this->pingServer($server);
        }
    }

    private function pingServer(Server $server): void
    {
        $host = $server->ip;
        $success = false;

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = "ping -n 1 -w 1000 " . escapeshellarg($host);
            $output = shell_exec($command);
            $success = stripos($output, 'Reply from') !== false || stripos($output, 'TTL=') !== false;
        } else {
            $command = "ping -c 1 -W 1 " . escapeshellarg($host);
            $output = shell_exec($command . " 2>&1");
            $success = stripos($output, '1 packets transmitted, 1 received') !== false || stripos($output, '64 bytes from') !== false;
        }

        $server->update([
            'ping_status' => $success ? 'ok' : 'failed',
            'pinged_at' => now(),
        ]);

        Log::info("Ping {$server->name} ({$server->ip}): " . ($success ? 'OK' : 'FAILED'));
    }
}