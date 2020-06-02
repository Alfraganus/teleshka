<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePprEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppr_events', function (Blueprint $table) {
            $table->increments('id');
            $table->date('ppr_date')->nullable();
            $table->string('shift',30)->nullable();
            $table->string('ppr_responsible_employee_tabel', 255)->nullable();
            $table->string('brigadir_tabel')->nullable();
            $table->integer('telly_number', 100)->nullable();
            $table->integer('department_name')->nullable();
            $table->text('technical_review_conclusion')->nullable();
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
        Schema::dropIfExists('ppr_events');
    }
}
