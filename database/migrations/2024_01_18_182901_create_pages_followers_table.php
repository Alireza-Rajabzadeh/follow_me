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
        Schema::create('pages_followers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_page_id');
            $table->foreign('user_page_id')->references('id')->on('user_pages');

            $table->unsignedBigInteger('follow_page_id');
            $table->foreign('follow_page_id')->references('id')->on('user_pages');

            $table->unique(['user_page_id', 'follow_page_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_page_id');
    }
};
