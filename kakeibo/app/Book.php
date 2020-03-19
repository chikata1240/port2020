<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = "id";


    protected $fillable = [
        'family_number',
        'budget',
        'money',
        'memo',
        'days',
    ];

    public function member()
    {
        return $this->belongsTo('App\Member', 'family_number', 'id');
    }

    public function scopeNameEqual($query, $str)
    {
        return $query->where('days', $str);
    }
    public function scopeFamilyEqual($query, $str)
    {
        return $query->where('family_code', $str);
    }
}
