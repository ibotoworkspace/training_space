<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quiz_id',10)->unsigned()->nullable();
            $table->text('question');
            $table->string('question_type', 100)->nullable();
            $table->string('answer1',255)->nullable();
            $table->string('answer2',255)->nullable();
            $table->string('answer3',255)->nullable();
            $table->string('answer4',255)->nullable();
            $table->string('answer5',255)->nullable();
            $table->string('correct_answer', 100)->nullable();
            $table->integer('score',5)->default(1);
            $table->text('remarks')->nullable();
            $table->integer('ordering')->nullable();
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quizes')->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
