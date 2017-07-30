<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_company_name', 30);
            $table->string('client_contact_name', 30)->nullable();
            $table->string('client_contact_phone', 14)->nullable();
            $table->string('client_contact_email', 45)->nullable();
            $table->string('first_contact_by', 20)->nullable();
            $table->date('first_contact_date')->nullable();            
            $table->string('province', 20)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('details', 255)->nullable();
            $table->string('land_ownership', 30)->nullable();
            $table->boolean('land_access_granted')->default(false);
            $table->string('land_access_granted_by', 30)->nullable();
            $table->string('land_access_contact', 30)->nullable();
            $table->string('land_access_phone', 14)->nullable();
            $table->string('plans', 255)->nullable();
            $table->string('work_type', 30)->nullable();
            $table->string('work_overview', 255)->nullable();
            $table->date('response_by')->nullable();
            $table->decimal('estimate', 13, 2)->default(0);
            $table->date('approval_date')->nullable(); 
            $table->date('invoiced_date')->nullable();
            $table->date('invoice_paid_date')->nullable(); 
            $table->decimal('invoice_amount', 13, 2)->default(0);           
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
        Schema::dropIfExists('projects');
    }
}
