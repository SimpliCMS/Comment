<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {

    public function up() {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->boolean('active')->default(false);
            $table->text('body');
            $table->morphs('commentable');
            $table->morphs('creator');
            NestedSet::columns($table);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('comments');
    }

}
