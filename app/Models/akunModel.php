<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class akunModel extends AuthUser
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    protected $hidden = [
        'username',
        'password'
    ];
    protected $fillable = ['username', 'password', 'role'];
}
