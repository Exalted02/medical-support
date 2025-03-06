<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_availability_statuses', function (Blueprint $table) {
            $table->id();
			$table->integer('emp_id')->nullable();
			$table->tinyInteger('is_available')->default(0)->comment('1=yes,0=no');
			$table->date('availability_date')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_availability_statuses');
    }
};
