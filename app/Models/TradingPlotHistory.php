<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property float plot_one_value
 * @property float plot_two_value
 * @property string state
 * @property string ticker
 * @property string exchange
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TradingPlotHistory extends Model
{
    use HasFactory, Notifibable;

    protected $table = 'trading_plot_history';

    protected $fillable = ['plot_one_value', 'plot_two_value', 'ticker', 'exchange', 'state', 'client_ip'];

    public function casts(): array
    {
        return [
            'plot_one_value' => 'decimal:2',
            'plot_two_value' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
