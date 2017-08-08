<?php

use PaschalDev\Laravauth\Facades\Laravauth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravauthTokenColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( Laravauth::getUserModelTableName(), function(Blueprint $table){

            $table->longText( config('laravauth.token_column_name') )->nullable();
            $table->string( config('laravauth.token_type_column_name') , 20)->nullable();
            $table->timestamp( config('laravauth.token_column_name').'_created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( Laravauth::getUserModelTableName(), function(Blueprint $table){

            $table->dropColumn([ 
                config('laravauth.token_column_name'), 
                config('laravauth.token_type_column_name'), 
                config('laravauth.token_column_name').'_created_at'
                ]);
        });
    }
}
