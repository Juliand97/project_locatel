<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanckMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_movements', function (Blueprint $table) {
            $table->id();
            $table->string('account_number',15);
            $table->string('type_transation',3);
            $table->decimal('value_transation',10,2);
            $table->string('state_transation',3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_movements');
    }
}
