<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'attendee_id',
        'disabilities',
        'sex',
        'baranggay',
    ];

    // Define the relationship with the Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Define the relationship with the Attendee
    public function attendee()
    {
        return $this->belongsTo(PersonWithDisability::class, 'attendee_id');
    }
}
