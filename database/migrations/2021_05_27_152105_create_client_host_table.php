<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientHostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_host', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
            $table->foreignId('host_id')
                ->references('id')
                ->on('hosts')
                ->onDelete('cascade');
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
        Schema::dropIfExists('client_host');
    }
}
