<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

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
}
