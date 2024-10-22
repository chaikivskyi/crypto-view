<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property array plot_data
 * @property string state
 * @property string ticker
 * @property string exchange
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TradingPlotHistory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'trading_plot_history';

    protected $fillable = ['plot_data', 'ticker', 'exchange', 'state', 'client_ip'];

    public function minPlotValue(): Attribute
    {
        return Attribute::make(
            get: fn () => min($this->plot_data)
        );
    }

    public function maxPlotValue(): Attribute
    {
        return Attribute::make(
            get: fn () => max($this->plot_data)
        );
    }

    public function casts(): array
    {
        return [
            'plot_data' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
