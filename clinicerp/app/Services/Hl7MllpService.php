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

    public function parseAck(string $rawAck): array
    {
        $ack = trim(str_replace(["\x0b", "\x1c", "\x0d"], ["", "", "\n"], $rawAck));
        $lines = array_values(array_filter(array_map('trim', explode("\n", $ack))));
        $msa = null;
        foreach ($lines as $line) {
            if (str_starts_with($line, 'MSA|')) {
                $msa = $line;
                break;
            }
        }

        if (! $msa) {
            return [
                'ack_code' => null,
                'ack_control_id' => null,
                'ack_text' => 'ACK sem segmento MSA',
                'accepted' => false,
            ];
        }

        $parts = explode('|', $msa);
        $ackCode = $parts[1] ?? null;

        return [
            'ack_code' => $ackCode,
            'ack_control_id' => $parts[2] ?? null,
            'ack_text' => $parts[3] ?? null,
            'accepted' => $ackCode === 'AA',
        ];
    }
}
