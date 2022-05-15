<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('author')->nullable();
            $table->integer('rating');
            $table->foreignId('book_id')->references('id')->on('books');
            $table->timestamps();
        });

        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('author')->nullable();
            $table->integer('rating');
            $table->foreignId('blog_id')->references('id')->on('blogs');
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
        Schema::dropIfExists('book_comments');
    }
};
