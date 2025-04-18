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
        Schema::create('employee_manage_tickets', function (Blueprint $table) {
            $table->id();
			$table->integer('emp_id')->nullable();
			$table->integer('department_id')->nullable();
			$table->integer('ticket_id')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_manage_tickets');
    }
};
