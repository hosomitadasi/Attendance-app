<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditRequest extends Model
{
    use HasFactory;

    protected $fillable = ['attendance_id', 'user_id', 'new_start_time', 'new_end_time', 'new_resets', 'reason'];
}
