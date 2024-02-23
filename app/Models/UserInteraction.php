<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_name',
        'request_body',
        'query_params',
        'response_code',
        'response_body',
        'source_ip',
    ];

    protected $casts = [
        'request_body' => 'json',
        'query_params' => 'json',
        'response_body' => 'json',
    ];
}
