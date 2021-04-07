<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'mail_driver',
        'host_name',
        'port_name',
        'user_name',
        'from_name',
        'subject'
    ];
}
