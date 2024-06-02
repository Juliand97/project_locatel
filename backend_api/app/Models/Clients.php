<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $fillable = ["iden_clie"
                          ,"last_name"
                          ,"name_clie"
                          ,"email"
                          ,"phone_clie"
                          ,"state"];
}
