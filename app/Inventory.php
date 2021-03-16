<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getMonthNameAttribute()
    {
        return Carbon::parse($this->year.'-'.$this->month)->monthName;
    }

    public function scopeAscOrder($query)
    {
        $query->orderBy('year')->orderBy('month');
    }
}
