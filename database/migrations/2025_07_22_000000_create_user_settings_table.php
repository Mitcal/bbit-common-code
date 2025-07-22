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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->integer('setting_id')->index();
            $table->string('setting_name')->nullable()->index();
            $table->bigInteger('user_id')->index();
            $table->string('s_value')->nullable();
            $table->integer('i_value')->nullable();
            $table->float('f_value')->nullable();
            $table->dateTime('t_value')->nullable();
            $table->text('text_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
