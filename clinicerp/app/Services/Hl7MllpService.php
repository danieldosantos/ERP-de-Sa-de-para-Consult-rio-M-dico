<?php

namespace App\Services;

class Hl7MllpService
{
    public function sendOrm(string $host, int $port, string $hl7Message): string
    {
        $mllp = "\x0b".str_replace(["\r\n", "\n"], "\r", trim($hl7Message))."\x1c\x0d";

        $client = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, 10);
        if (! $client) {
            throw new \RuntimeException("Falha ao conectar no DCM4CHEE: {$errstr} ({$errno})");
        }

        fwrite($client, $mllp);
        stream_set_timeout($client, 10);
        $response = fread($client, 4096) ?: '';
        fclose($client);

        return $response;
    }
}
