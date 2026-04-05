<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Vertical extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
