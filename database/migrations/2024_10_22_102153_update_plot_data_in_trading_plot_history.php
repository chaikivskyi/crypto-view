<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $plotHistories = DB::table('trading_plot_history')
                ->get(['id', 'plot_one_value', 'plot_two_value']);

            foreach ($plotHistories as $plotHistory) {
                $plotData = json_encode([
                    'plot_0' => $plotHistory->plot_one_value,
                    'plot_1' => $plotHistory->plot_two_value,
                ]);

                DB::table('trading_plot_history')
                    ->where('id', $plotHistory->id)
                    ->update(['plot_data' => $plotData]);
            }
        });
    }

    public function down(): void
    {
        DB::table('trading_plot_history')->update(['plot_data' => '']);
    }
};
