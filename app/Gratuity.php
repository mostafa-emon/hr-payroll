<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Gratuity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
