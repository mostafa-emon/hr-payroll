<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Audit extends Model
{
    public function __construct($attributes = [])
    {
        $this->attributes['company_id'] = Auth::user()->company_id;
        parent::__construct($attributes);
    }

    protected $fillable = [
        'user_type ', 'user_id ', 'event', 'auditable_type', 'auditable_id', 'ip_address', 'user_agent'
    ];
}
