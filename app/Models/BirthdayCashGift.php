<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdayCashGift extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function personWithDisability()
    {
        return $this->belongsTo(PersonWithDisability::class);
    }

}
