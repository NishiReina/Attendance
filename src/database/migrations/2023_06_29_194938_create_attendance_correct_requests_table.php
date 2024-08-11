<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceCorrectRequestsTable extends Migration
{

    /**
     * status
     *  0: 申請中
     *  1: 承認済み 
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_correct_requests', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0);    
            $table->string('reason');    
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            // $table->unsignedBigInteger('attendance_id')->unique();
            // $table->foreign('attendance_id')->references('id')->on('attendances');
            $table->foreignId('attendance_id')->constrained();
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
        Schema::dropIfExists('attendance_correction_requests');
    }
}
