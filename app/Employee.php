<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function EmploymentInfo() {
        return $this->belongsTo(EmploymentInfo::class);
    }
}
