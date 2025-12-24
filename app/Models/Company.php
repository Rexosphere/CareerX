<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'logo_path',
        'description',
        'status',
        'verification_token',
        'verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'verified_at' => 'datetime',
    ];

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }

    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn($n) => mb_substr($n, 0, 1))
            ->join('');
    }
}
