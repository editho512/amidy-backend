<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    CONST TYPE = ['Customer', 'Administrator', 'Super administrator'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'email',
        'phone',
        'adresse',
        'type',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $this->getUserTypeByValue($value);
    }

    public function getTypeAttribute(){
        return self::TYPE[$this->attributes['type']];
    }

    private function getUserTypeByValue(String $userType): int
    {
        foreach (self::TYPE as $key => $type) {
            if ($type === $userType) return $key;
        }
    }
}
