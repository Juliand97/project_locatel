<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\BankAccount;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{

    /**
     * Crea el numero de cuenta 
     * basado en el numero de identificacion 
     * mas un hash
     */
    public function create_numb_account($iden_user){
        $first_hash=base64_decode("MTIxNTM=");
        $second_hash=substr(crc32($iden_user),0,3);
        $third_hash=rand(1,100);
        $third_hash_valid=(string)$third_hash;
        $valdidate_last_hash=(strlen($third_hash_valid) >0) ? $third_hash: "0".$third_hash;
        $numb_account="{$first_hash}-{$second_hash}-{$valdidate_last_hash}";
        return $numb_account;
    }

    /**
     * Guarda la informacion de un cliente 
     * y crea una cuenta de ahorros
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $validatedData = $request->validate([
            'iden_clie' => 'required|string|max:10|min:5|unique:clients',
            'last_name' => 'required|string|max:250',
            'name_clie' => 'required|string|max:250',
            'email' => 'required|string|email|max:100',
            'phone_clie' => 'required|string|max:12'
        ]);

        DB::transaction(function() use ($validatedData){
            $new_client= new Clients();
            $new_client->iden_clie=$validatedData["iden_clie"];
            $new_client->last_name=$validatedData["last_name"];
            $new_client->name_clie=$validatedData["name_clie"];
            $new_client->email=$validatedData["email"];
            $new_client->phone_clie=$validatedData["phone_clie"];
            $new_client->state="ACT";
            $new_client->save();
            
            $bankAccounts= new BankAccount();
            $bankAccounts->iden_user=$validatedData["iden_clie"];
            $bankAccounts->type_account=1;
            $bankAccounts->account_number=self::create_numb_account($validatedData["iden_clie"]);
            $bankAccounts->current_cash=0;
            $bankAccounts->state="ACT";
            $bankAccounts->save();
        });

        $account_info=BankAccount::where("iden_user",$validatedData["iden_clie"])->first();
        $account_numb="";
        if ($account_info) {
            $account_numb=$account_info->account_number;
        }
        $data=array();
        $data["iden_clie"]=$validatedData["iden_clie"];
        $data["account_numb"]=$account_numb;

        $response=parent::send_response(true,'Cliente Creado',$data);
        return response()->json($response);
    }

    /**
     * Muestra la informacion del cliente y sus movimientos en cuenta
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $validatedData = $request->validate([
            'iden_clie' => 'required|string|max:10|min:5'
        ]);

        $client=Clients::where("iden_clie",$validatedData["iden_clie"])->first();
        if (!$client) {
            $response=parent::send_response(false,'Cliente No Encontrado');
            return response()->json($response);
        }

        $account_info=BankAccount::where("iden_user",$client->iden_clie)->first();
        $data=array();
        $data["iden_clie"]=$client->iden_clie;
        $data["full_name"]="{$client->last_name} {$client->name_clie}";
        $data["phone_clie"]=$client->phone_clie;
        $data["email"]=$client->email;
        $data["account_number"]=(!$account_info) ? '':$account_info->account_number;

        $response=parent::send_response(true,'Cliente Encontrado',$data);
        return response()->json($response);
    }

    /**
     * Inactiva un cliente y su cuenta
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $validatedData = $request->validate([
            'iden_clie' => 'required|string|max:10|min:5'
        ]);

        $client=Clients::where("iden_clie",$validatedData["iden_clie"])->first();
        if (!$client) {
            $response=parent::send_response(false,'Cliente No Encontrado');
            return response()->json($response);
        }

        $update_client=Clients::where("iden_clie",$validatedData["iden_clie"])->update(['state' => 'INA']);
        if($update_client>0){
            $msg_ext=" Inactivado. Adicionalmente, se inactivo la cuenta bancaria del usuario. ";
            $update_bank_acconut=BankAccount::where("iden_user",$validatedData["iden_clie"])->update(['state' => 'INA']);
            
            $response=parent::send_response(true,"Cliente{$msg_ext} ");
        }else {
            $response=parent::send_response(false,'Error al Actualizar Cliente');
        }
        
        return response()->json($response);
    }

}
