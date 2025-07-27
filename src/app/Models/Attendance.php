<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'start_time', 'end_time', 'note' ];

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public static function getAttendance()
    {
        $id = Auth::id();
        $date = Carbon::now()->toDateString();

        return self::with('rests')->where('user_id', $id)->where('date', $date)->first();
    }

    public function getRestSumAttribute()
    {
        $totalSeconds = 0;

        foreach ($this->rests as $rest) {
            if ($rest->start_time && $rest->end_time) {
                $totalSeconds += Carbon::parse($rest->end_time)->diffInSeconds(Carbon::parse($rest->start_time));
            }
        }

        return gmdate('H:i:s', $totalSeconds);
    }

    public function getWorkTimeAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return null;
        }

        $totalSeconds = Carbon::parse($this->end_time)->diffInSeconds(Carbon::parse($this->start_time));

        foreach ($this->rests as $rest) {
            if ($rest->start_time && $rest->end_time) {
                $totalSeconds -= Carbon::parse($rest->end_time)->diffInSeconds(Carbon::parse($rest->start_time));
            }
        }

        return gmdate('H:i:s', $totalSeconds);
    }
}
