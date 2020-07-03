<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
