<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socket\Raw\Factory;
use Socket\Raw\Socket;

class MonitorTcp extends Controller
{
    public function index()
    {
        return view('command');
    }

    public function store(Request $request)
    {
        $ack = "060101000600";
        $command = trim(str_replace(" ", "", ($request->input('command'))));
        $host = "tcp://{$request->input('ip')}:{$request->input('port')}";

        try {
            $factory = new Factory();
            $socket = $factory->createClient($host, 3);
        } catch (\Exception $e) {
            return response()->json(['ack' => false, 'reason' => $e->getMessage()]);
        }

        $socket->write(hex2bin($command));

        if ($socket->selectRead(3)) {
            $response = bin2hex($socket->read(1024));
            if ($response == $ack) {
                return response()->json(['ack' => true, 'reason' => sprintf('valid signature %s', $response)]);
            }
            return response()->json(['ack' => false, 'reason' => sprintf('invalid signature %s', $response)]);
        }

        return response()->json(['ack' => false, 'reason' => "read timeout"]);
    }
}
