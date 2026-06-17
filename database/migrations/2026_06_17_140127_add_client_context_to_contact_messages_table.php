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
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('device_type', 20)->nullable()->after('user_agent');
            $table->string('browser', 50)->nullable()->after('device_type');
            $table->string('platform', 50)->nullable()->after('browser');
            $table->string('accept_language')->nullable()->after('platform');
            $table->string('referer')->nullable()->after('accept_language');
            $table->json('client_metadata')->nullable()->after('referer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn([
                'user_agent',
                'device_type',
                'browser',
                'platform',
                'accept_language',
                'referer',
                'client_metadata',
            ]);
        });
    }
};
