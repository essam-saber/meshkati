<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgingOfDebit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeDescOrder($query)
    {
        $query->orderBy('year', 'desc')->orderBy('month', 'desc');
    }

    public function scopeAscOrder($query)
    {
        $query->orderBy('year', 'asc')->orderBy('month', 'asc');
    }

    public function attribute()
    {
        return $this->belongsTo(AgingAttribute::class, 'attribute_id', 'id');
    }
}
