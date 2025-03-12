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
        Schema::table('manage_chat_files', function (Blueprint $table) {
           $table->string('chat_group_id')->nullable()->after('manage_chat_id');
		   $table->tinyInteger('file_type')->default(1)->comment('1=image')->after('chat_group_id');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manage_chat_files', function (Blueprint $table) {
            //
        });
    }
};
