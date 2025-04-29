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
       Schema::create('chat_reasons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('department')->nullable();
            $table->text('reason')->nullable();
			$table->tinyInteger('is_supervisor_get_message')->default(0)->comment('0=no, 1=yes');
			$table->tinyInteger('group_value')->default(0)->comment('0=What is the reason for the new chat?, 1=Customer Service /Complaint, 2=Urgent Answer');
            $table->tinyInteger('status')->default(1)->comment('0=inactive; 1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_reasons');
    }
};
