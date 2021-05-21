<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Download;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function getFileList()
    {
        return [
            '/file/category_a/1.pdf',
            '/file/category_a/2.pdf',
            '/file/category_b/3.pdf',
            '/file/category_b/4.pdf',
            '/file/category_b/5.pdf',
            '/file/category_b/6.pdf',
            '/file/category_b/7.pdf',
            '/file/category_b/8.pdf',
            '/file/category_b/9.pdf',
            '/file/category_b/10.pdf'
        ];
    }
}
