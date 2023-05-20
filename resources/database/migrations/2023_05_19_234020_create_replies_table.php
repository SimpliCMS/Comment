<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration {

    public function up() {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');
            $table->integer('user_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('type_id')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('replies');
    }

}
