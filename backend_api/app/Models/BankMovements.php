<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankMovements extends Model
{
    use HasFactory;
    protected $fillable = ["account_number"
    ,"type_transaction"
    ,"value_transaction"
    ,"state_transaction"];
}
