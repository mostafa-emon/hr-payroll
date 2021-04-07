<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SalaryComponent extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
