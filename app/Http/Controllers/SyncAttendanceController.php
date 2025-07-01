<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Attendance;


class SyncAttendanceController extends Controller
{
    public function syncAttendance()
    {
        $apiKey = env('ZKTeco_API_KEY');
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-TOKEN' => $apiKey,
        ])->post(setting('clock.url'), [
            'ip' => setting('clock.ip'),
            'port'=> setting('clock.port'),
            'password'=>setting('clock.password')
        ]);
        $data = $response->json();
        return $data;

        // $response = Http::withHeaders([
        //     'X-API-Key' => $apiKey,
        // ])->get($url);


      
    }
}
