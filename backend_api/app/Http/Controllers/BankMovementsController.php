<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankMovements;
use App\Models\BankAccount;
use App\Models\Clients;
use Illuminate\Support\Facades\DB;


class BankMovementsController extends Controller
{
   

    /**
     * Metodo para agregar consignaciones 
     * este metodo añade el movimiento realizado a
     * la tabla BankMovements
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validatedData = $request->validate([
            'account_number' => 'required|string|max:15|min:5',
            'value_transaction' => ['required', 'numeric', 'regex:/^\d{1,10}(\.\d{1,2})?$/'], 
        ]);

        $account_info=BankAccount::where("account_number",$validatedData["account_number"])->first();
        if (!$account_info) {
            $response=parent::send_response(false,'Numero De Cuenta No Encontrada');
            return response()->json($response);
        }
        
        $valid_clie_active=Clients::where("iden_clie",$account_info->iden_user)
                                  ->where("state",'ACT')->first();
        
        if (!$valid_clie_active) {
            $response=parent::send_response(false,'Cliente No Esta Activo');
            return response()->json($response);
        }

        DB::transaction(function() use ($validatedData){
            $account_info=BankAccount::where("account_number",$validatedData["account_number"])->first();

            $save_movement=new BankMovements();
            $save_movement->account_number=$validatedData["account_number"];
            $save_movement->value_transaction=$validatedData["value_transaction"];
            $save_movement->type_transaction="CON";
            $save_movement->state_transaction="CER";
            $save_movement->save();
    
            $update_bank_acconut=BankAccount::where("account_number",$validatedData["account_number"])
                                             ->where("iden_user",$account_info->iden_user)
                                             ->update(['current_cash' => ((int)$account_info->current_cash+(int)$validatedData["value_transaction"])]);
        });

        $response=parent::send_response(true,"Se Consigno {$validatedData["value_transaction"]} a la cuenta {$validatedData["account_number"]}");
        return response()->json($response);                            
    }

    /**
     * Metodo para generar retiros de dinero de la cuenta 
     * bancaria de un usuario
     * este metodo añade el movimiento realizado a
     * la tabla BankMovements
     */
    public function withdrawal(Request $request){
        $validatedData = $request->validate([
            'account_number' => 'required|string|max:15|min:5',
            'value_transaction' => ['required', 'numeric', 'regex:/^\d{1,10}(\.\d{1,2})?$/'], 
        ]);

        $account_info=BankAccount::where("account_number",$validatedData["account_number"])->first();
        if (!$account_info) {
            $response=parent::send_response(false,'Numero De Cuenta No Encontrada');
            return response()->json($response);
        }

        if ((int)$account_info->current_cash<(int)$validatedData["value_transaction"]) {
            $response=parent::send_response(false,'Saldo insuficiente para realizar la transaccion');
            return response()->json($response);
        }
        
        $valid_clie_active=Clients::where("iden_clie",$account_info->iden_user)
                                  ->where("state",'ACT')->first();
        
        if (!$valid_clie_active) {
            $response=parent::send_response(false,'Cliente No Esta Activo');
            return response()->json($response);
        }

        DB::transaction(function() use ($validatedData){
            $account_info=BankAccount::where("account_number",$validatedData["account_number"])->first();

            $save_movement=new BankMovements();
            $save_movement->account_number=$validatedData["account_number"];
            $save_movement->value_transaction=$validatedData["value_transaction"];
            $save_movement->type_transaction="RET";
            $save_movement->state_transaction="CER";
            $save_movement->save();
    
            $update_bank_acconut=BankAccount::where("account_number",$validatedData["account_number"])
                                             ->where("iden_user",$account_info->iden_user)
                                             ->update(['current_cash' => ((int)$account_info->current_cash+(int)$validatedData["value_transaction"])]);
        });

        $response=parent::send_response(true,"Se retiro {$validatedData["value_transaction"]} de la cuenta {$validatedData["account_number"]}");
        return response()->json($response);                       
    }
}
