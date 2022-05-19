<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Gig extends Model
{
    use HasFactory, Searchable;

    public const NOT_STARTED = 10;
    public const STARTED = 20;
    public const FINISHED = 30;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'start_time',
        'end_time',
        'number_of_positions',
        'pay_per_hour',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
