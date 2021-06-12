<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
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
        'email_verified_at',
        'password',
        'image',
        'fid',
        'gid',
        'policy',
        'active',
        'gender',
    ];

    public function reviews(){
        return $this->belongsToMany(Review::class);
    }


    public static function setUserArray($users)
    {

        $userArray = array();
        if ($users) {
            foreach ($users as $user) {
                array_push($userArray, User::build($user));
            }

            return $userArray;
        }

        return null;
    }

    public static function build(User $user): array
    {
        if ($user) {


            return [
                "id" => $user->id,
                "name" => $user->name,
                "image" => $user->image,
                "image_google" => $user->image_google,
                "image_facebook" => $user->image_facebook,
                "gender" => $user->gender,
                "active" => $user->active,
                "policy" => $user->policy,
            ];
        }
    }
    public static function buildSimple(User $user): array
    {
        if ($user) {


            $image = null;
            if ($user->image) {
                $image = User::setImage($user->image);
            }

            return [
                "id" => $user->id,
                "name" => $user->name,
                "image" => $image ? $image["path"] : null,
                "policy" => $user->policy,
            ];
        }
    }


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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
