<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SalarySheet extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
