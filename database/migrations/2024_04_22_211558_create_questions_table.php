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
            $table->integer('quiz_id')->unsigned()->nullable();
            $table->text('question');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice');
            $table->string('answer1')->nullable();
            $table->string('answer2')->nullable();
            $table->string('answer3')->nullable();
            $table->string('answer4')->nullable();
            $table->string('answer5')->nullable();
            $table->enum('correct_answer', ['answer1', 'answer2', 'answer3', 'answer4', 'answer5'])->nullable();
            $table->integer('score')->default(1);
            $table->text('remarks')->nullable();
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
