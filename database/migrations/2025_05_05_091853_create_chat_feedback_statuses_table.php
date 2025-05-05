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
        Schema::create('chat_feedback_statuses', function (Blueprint $table) {
            $table->id();
			$table->string('chat_group_id')->nullable();
			$table->longText('feedback_text')->nullable();
			$table->tinyInteger('chat_status')->default(0)->comment('0=no feedback, 1=positive feedback, 2=negative feedback');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_feedback_statuses');
    }
};
