<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('domain');
            $table->date('domain_end');
            $table->foreignId('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');
            $table->foreignId('host_id')
                ->references('id')
                ->on('hosts')
                ->onDelete('cascade');
            $table->date('host_end');
            $table->string('ftp_login');
            $table->string('ftp_password');
            $table->string('db_login');
            $table->string('db_password');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
