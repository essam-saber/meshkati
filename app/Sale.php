<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getMonthNameAttribute()
    {
        return Carbon::parse($this->year.'-'.$this->month)->monthName;
    }

    public function scopeDescOrder($query)
    {
        $query->orderBy('year', 'desc')->orderBy('month', 'desc');
    }

    public function scopeAscOrder($query)
    {
        $query->orderBy('year', 'asc')->orderBy('month', 'asc');
    }

    public function getRoundedGrossProfitPercentageAttribute()
    {
        return (float)round($this->gross_profit_percentage, 0);
    }

    public function getRoundedGrossProfitCumPercentageAttribute()
    {
        return (float)round($this->gross_profit_cum_percentage, 0);
    }

    public function getRoundedNetProfitPercentageAttribute()
    {
        return (float)round($this->net_profit_percentage, 0);

    }

    public function getRoundedNetProfitCumPercentageAttribute()
    {
        return (float)round($this->net_profit_cum_percentage, 0);
    }
}
