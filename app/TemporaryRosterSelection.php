<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TemporaryRosterSelection extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
