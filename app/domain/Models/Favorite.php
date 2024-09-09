<?php

namespace App\domain\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * @var string
     */
    protected $table = "favorites";

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'gif_id',
        'alias',
    ];

}
