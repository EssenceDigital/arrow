<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned(); // Foreign key
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('plans', 30)->nullable();
            $table->string('work_type', 30)->nullable();
            $table->string('work_overview', 150)->nullable();
            $table->date('response_by')->nullable();
            $table->decimal('estimate', 13, 2)->default(0);
            $table->date('approval_date')->nullable();  
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
        Schema::dropIfExists('proposals');
    }
}
