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
        Schema::create('trading_plot_history', function (Blueprint $table) {
            $table->id();
            $table->decimal('plot_one_value', 10);
            $table->decimal('plot_two_value', 10);
            $table->string('ticker', 10)->nullable();
            $table->string('exchange', 10)->nullable();
            $table->string('state', 10);
            $table->string('client_ip', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhooks');
    }
};
