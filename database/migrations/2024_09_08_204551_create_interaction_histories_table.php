<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('interaction_history', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('user_id')->nullable();
            $table->string('service');
            $table->json('request_body');
            $table->integer('response_code');
            $table->longText('response_body');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaction_history');
    }
};
