<?php

namespace App\Http\Controllers;

class TransportController extends Controller
{
    public function index()
    {
        $transports = \App\Models\Transport::with(['stops', 'schedules'])->first();

        dd($transports->toArray());
    }
}
