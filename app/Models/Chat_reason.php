<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_reason extends Model
{
    use HasFactory;
	protected $table = 'chat_reasons';
	protected $fillable = [
        'id',
        'reason',
        'status',
    ];
}
