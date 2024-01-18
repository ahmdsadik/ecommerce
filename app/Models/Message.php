<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
    ];

//    protected $with = [
//        'user'
//    ];



    /******************** Relations ********************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
