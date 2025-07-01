<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use DateTime;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function custom_authorize($permission){
        if(!Auth::user()->hasPermission($permission)){
            abort(403, 'THIS ACTIO UNAUTHORIZED.');
        }
    }

    public function payment_alert()
    {
        $soliciondigital = new SolucionDigitalController();
        $data = $soliciondigital->settings_code();
        $date = $data->finish;

        $now = new DateTime();
        $value= null;
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date.' 23:59:59');
    
        if($data->type == 'Demo')
        {
            return $value;
        }

        if($d && $d->format('Y-m-d') === $date )
        {
            if($now > $d)
            {
                $value = "finalizado";
            }
            else
            {
                $difference = $now->diff($d);
                if($difference->days <= 3)
                {
                    $value = $difference->days;
                }
                else
                {
                    $value = "vigente";
                }
            }
        }
        else
        {
            $value = null;
        }
        return $value;
    }
}
