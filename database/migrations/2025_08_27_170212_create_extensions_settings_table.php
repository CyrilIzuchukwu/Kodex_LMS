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
        Schema::create('extensions_settings', function (Blueprint $table) {
            $table->id();
            $table->string('google_tag')->nullable();
            $table->string('smartsupp_key')->nullable();
            $table->longText('zoho_salesiq')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('telegram_username')->nullable();
            $table->string('intercom_app_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extensions_settings');
    }
};
