<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\BankMovements;


class BankAccountController extends Controller{

    /**
     * Muestra la informacion de la cuenta 
     * bancaria del usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_info_account(Request $request){
        $validatedData = $request->validate(['account_number' => 'required|string|max:15|min:5']);
        $account_info=BankAccount::where("account_number",$validatedData["account_number"])->first();
        if (!$account_info) {
            $response=parent::send_response(false,'Numero De Cuenta No Encontrada');
            return response()->json($response);
        }
       
        $movements=BankMovements::where("account_number",$validatedData["account_number"])->get();
        if (!$movements) {
            $response=parent::send_response(false,'No existen movimientos aun');
        }

        $data=array();
        $data["account_number"]=$account_info->account_number;
        $data["current_cash"]=$account_info->current_cash;
        $data["current_movements"]=(!$movements) ? 'No existen movimientos aun':$movements;
        $response=parent::send_response(true,'Informacion cuenta',$data);
        return response()->json($response);

    }



}
