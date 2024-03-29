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

    public static function reviews(User $user){

        return Review::join('review_users','review_users.review_id','=','reviews.id')
        ->select('review_id as id', 'title','question','description', 'include_criteria','exclude_criteria','instituition_id','accepted')
        ->where('review_users.user_id',$user->id)->get();
    }



    public static function setUserArray($users)
    {

        $userArray = array();
        if ($users) {
            foreach ($users as $user) {
                array_push($userArray, User::build($user, $user['accepted']));
            }

            return $userArray;
        }

        return null;
    }

    public static function build(User $user, $accepted=0): array
    {
        if ($user) {


            return [
                "id" => $user->id,
                "fcm_web_key" => $user->fcm_web_key,
                "fcm_mobile_key" => $user->fcm_mobile_key,
                "name" => $user->name,
                "image" => $user->image,
                "gender" => $user->gender,
                "active" => $user->active,
                "policy" => $user->policy,
                "accepted" => $accepted,
            ];
        }
    }
    public static function buildSimple(User $user): array
    {
        if ($user) {
               return [
                "id" => $user->id,
                "name" => $user->name,
                "image" => $user->image,
                "policy" => $user->policy,
                "fcm_web_key" => $user->fcm_web_key,
                "fcm_mobile_key" => $user->fcm_mobile_key,
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
