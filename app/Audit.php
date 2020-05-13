<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'user_type ', 'user_id ', 'event', 'auditable_type', 'auditable_id', 'ip_address', 'user_agent'
    ];
    
}
