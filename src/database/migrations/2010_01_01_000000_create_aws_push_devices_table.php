<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwsPushDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_push_devices', function (Blueprint $table) {
            $table->increments('id');

            $table->char('arn', 255);
            $table->char('device_id', 255)->nullable();
            $table->char('platform', 255); // ios or android
            $table->char('model', 255)->nullable();
            $table->char('os_version', 255)->nullable();

            $table->char('owner_id', 50)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('aws_push_devices');
    }
}
