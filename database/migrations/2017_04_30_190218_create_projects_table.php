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
            $table->string('province', 20);
            $table->string('location', 100);
            $table->string('details', 150)->nullable();
            $table->string('client_company_name', 30);
            $table->string('client_contact_name', 30);
            $table->string('client_contact_phone', 14);
            $table->string('client_contact_email', 45)->nullable();
            $table->string('first_contact_by', 20);
            $table->date('first_contact_date');
            $table->string('land_ownership', 30)->nullable();
            $table->boolean('land_access_granted')->default(false);
            $table->string('land_access_granted_by', 30)->nullable();
            $table->string('land_access_contact', 30)->nullable();
            $table->string('land_access_phone', 14)->nullable();
            $table->date('invoiced_date')->nullable();
            $table->date('invoice_paid_date')->nullable();
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
