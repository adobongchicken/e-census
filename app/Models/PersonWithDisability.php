<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonWithDisability extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function educationalAttainment()
    {
        return $this->hasOne(EducationalAttainment::class);
    }
    public function employmentRecord()
    {
        return $this->hasMany(EmploymentRecord::class);
    }
    public function disabilityType()
    {
        return $this->hasOne(DisabilityType::class);
    }
    public function submittedForm()
    {
        return $this->hasOne(SubmittedForm::class);
    }
    public function programAttendance()
    {
        return $this->hasOne(ProgramAttendance::class);
    }
    public function guardians() {
        return $this->hasOne(Guardian::class);
    }
    public function birthdayCashGift() {
        return $this->hasOne(BirthdayCashGift::class);
    }
}
