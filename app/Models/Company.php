<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'posted_gigs',
        'started_gigs'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function getPostedGigsAttribute()
    {
        return $this->gigs()->count();
    }

    public function getStartedGigsAttribute()
    {
        return $this->gigs()
            ->where('start_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('status', '=', true)
            ->count();
    }
}
