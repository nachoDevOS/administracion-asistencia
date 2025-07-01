<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SolucionDigitalController extends Controller
{
    public function settings_code() 
    {
        return DB::connection('solucionDigital')->table('web_systems')->where('code', setting('system.code'))->first();
    }
}
