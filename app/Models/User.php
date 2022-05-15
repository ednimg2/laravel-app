<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_CONTENT_MANAGER = 'ROLE_CONTENT_MANAGER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const TYPE_B2B = 'b2b';
    public const TYPE_B2C = 'b2c';
    public const TYPE_AD_HOC = 'ad_hoc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'roles'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function awards()
    {
        //select userid -> select from blogs where user_id = {user_id} => select from awards where blog_id = {blog_id}
        return $this->hasManyThrough(Award::class, Blog::class, 'author_id');
    }

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function scopeB2b(Builder $builder) {
        $builder->where('type', '=', self::TYPE_B2B);
    }

    public function scopeB2c(Builder $builder) {
        $builder->where('type', '=', self::TYPE_B2C);
    }

    public function scopeAdHoc(Builder $builder) {
        $builder->where('type', '=', self::TYPE_AD_HOC);
    }

    public function scopeReverseSorting(Builder $builder) {
        $builder->orderByDesc('email');
    }

    public function scopeDefaultSorting(Builder $builder)
    {
        $builder->orderBy('email');
    }
}
