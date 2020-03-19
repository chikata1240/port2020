<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'family_code',
        'password',
    ];

    public function book()
    {
        return $this->hasOne('App\Book', 'family_number', 'id');
    }

    public function getData()
    {
        return $this->id . ": " . $this->name . ": " . $this->family_code;
    }

    public function getDataBook()
    {
        return $this->book->id . ": " . $this->book->money . ": " . $this->book->memo;
    }

    public function scopeCodeEqual($query, $str)
    {
        return $query->where('family_code', $str);
    }
}
