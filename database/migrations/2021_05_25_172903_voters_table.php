<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VotersTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
       public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('voters_id')->unique();
            $table->enum('voted', ['1', '0'])->default('0');            
            $table->enum('status', ['Active', 'Inactive'])->default('Active');            
            $table->rememberToken();
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
        Schema::dropIfExists('voters');
    }
}
