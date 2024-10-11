<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function programAttendance()
    {
        return $this->hasOne(ProgramAttendance::class);
    }
}
