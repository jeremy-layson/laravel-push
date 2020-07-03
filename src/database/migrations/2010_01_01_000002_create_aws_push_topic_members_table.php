<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwsPushTopicMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_push_topic_members', function (Blueprint $table) {
            $table->increments('id');

            $table->char('name', 255);
            $table->char('description', 255)->nullable();
            $table->char('arn', 255);

            $table->integer('aws_push_topic_id')->unsigned()->nullable()->index('aws_push_topic_members_aws_push_topic_id_foreign');
            $table->foreign('aws_push_topic_id')->references('id')->on('aws_push_topics')->onDelete('SET NULL');
            
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
        Schema::dropIfExists('aws_push_topic_members');
    }
}
