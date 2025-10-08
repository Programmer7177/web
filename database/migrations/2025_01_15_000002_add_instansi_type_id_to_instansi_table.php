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
        Schema::table('instansi', function (Blueprint $table) {
            $table->unsignedBigInteger('instansi_type_id')->after('instansi_id');
            $table->foreign('instansi_type_id')->references('instansi_type_id')->on('instansi_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            $table->dropForeign(['instansi_type_id']);
            $table->dropColumn('instansi_type_id');
        });
    }
};