<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontendLog extends Model
{
    protected $fillable = [
        'message',
        'stack',
        'context',
    ];
}
