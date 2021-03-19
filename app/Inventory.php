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

    public function getTotalAttribute() {
        return $this->goods_ready_for_sale + $this->finished_products + $this->semi_finished_products + $this->work_in_process + $this->raw_material + $this->spare_parts_and_others;
    }
}
