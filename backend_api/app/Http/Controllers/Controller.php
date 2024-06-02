<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**Estructura respuesta para json */
    public function send_response($state,$msg,$data=array()){
        $response=array();
        $response["state"]=($state) ? "success":"error";
        $response["msg"]=($msg!='') ? $msg:"";
        $response["data"]=(!empty($data)) ? $data:array();
        return $response;
    }
}
