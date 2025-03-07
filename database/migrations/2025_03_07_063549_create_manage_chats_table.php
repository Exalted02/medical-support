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
        Schema::create('manage_chats', function (Blueprint $table) {
            $table->id();
			$table->tinyInteger('source')->default(0)->comment('0=website,1=facebook,2=whatapp');
			$table->integer('user_type')->nullable();
			$table->string('chat_group_id')->nullable();
			$table->integer('sender_id')->nullable();
			$table->integer('receiver_id')->nullable();
			$table->text('message')->nullable();
			$table->tinyInteger('is_read')->default(0)->comment('0=unread,1=read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_chats');
    }
};
