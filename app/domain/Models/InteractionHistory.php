<?php

namespace App\domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InteractionHistory extends Model
{
    protected $table = 'interaction_history';

    protected $fillable = [
        'user_id',
        'service',
        'request_body',
        'response_code',
        'response_body',
        'ip_address',
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

