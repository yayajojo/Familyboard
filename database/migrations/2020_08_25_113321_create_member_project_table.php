<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_project', function (Blueprint $table) {
            $table->primary(['member_id','project_id']);
            $table->foreignId('member_id');
            $table->foreignId('project_id');
            $table->timestamps();
            $table->foreign('member_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('project_id')
            ->references('id')
            ->on('projects')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_project');
    }
}
