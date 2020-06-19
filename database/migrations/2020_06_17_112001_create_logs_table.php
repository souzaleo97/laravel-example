<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_logged_id')->nullable();
            $table->string('client_address', 255)->nullable();
            $table->string('method_request', 10)->nullable();
            $table->string('uri_request', 500)->nullable();
            $table->longText('data')->nullable();
            $table->longText('header_request')->nullable();
            $table->string('device_app_version', 255)->nullable();
            $table->string('device_name', 255)->nullable();
            $table->string('device_os', 255)->nullable();
            $table->string('device_uuid', 255)->nullable();
            $table->timestamps();

            $table
                ->foreign('user_logged_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
