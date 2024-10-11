<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Guardian extends Model
{
    use HasFactory, Notifiable;
    protected $guarded= [];

    public function personWithDisability()
    {
        return $this->belongsTo(PersonWithDisability::class);
    }
}
