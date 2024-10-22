<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trading_plot_history', function (Blueprint $table) {
            $table->dropColumn('plot_one_value');
            $table->dropColumn('plot_two_value');
        });
    }

    public function down(): void
    {
        Schema::table('trading_plot_history', function (Blueprint $table) {
            $table->decimal('plot_one_value', 10);
            $table->decimal('plot_two_value', 10);
        });
    }
};
