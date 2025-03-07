<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manage_chat_file extends Model
{
    use HasFactory;
	protected $table = 'manage_chat_files';
	protected $fillable = [
        'manage_chat_id',
        'file_name',
    ];
}
