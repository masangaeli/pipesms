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
        Schema::create('queue_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('contact_id');
            $table->integer('group_id');
            $table->string('to_phone_number');
            $table->longText('message_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_messages');
    }
};
