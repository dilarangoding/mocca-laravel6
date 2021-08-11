<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    protected $fillable = [
        'role', 'customer_id', 'name', 'email', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function getVerifyLabelAttribute()
    {
        if ($this->email_verified_at == Null) {
            return '<span class="badge badge-secondary">Belum Terverifikasi</span>';
        }

        return '<span class="badge badge-success">Sudah Terverifikasi</span>';
    }
}
