<?php

namespace App;

use App\Favorite;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SubscribeEmail;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN        = 0;
    const ROLE_USER         = 1;
    const NOT_SUBSCRIBE     = 0;
    const SUBSCRIBE         = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'subscribe'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get favourites.
     *
     * @return \App\Favorite
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Check if user has admin role.
     *
     * @return \Illuminate\Http\Response
     */
    public static function isAdmin()
    {
        if(Auth::user()->role != self::ROLE_ADMIN){
            abort(404);
        }
    }

    /**
     * Get subscribed users.
     *
     * @return \App\News
     */
    public static function subscribedUsers()
    {
        return self::where('subscribe', self::SUBSCRIBE)->get();
    }

    /**
     * Send email to subscribed users.
     *
     * @param \App\News
     */
    public static function sendEmailToAllSubscribers(News $news)
    {
        $subscribers = self::subscribedUsers();
        if (count($subscribers) > 0) {
            foreach ($subscribers as $subscriber) {
                $subscriber->notify(new SubscribeEmail($news, $subscriber));
            }
        }
    }

    /**
     * Subscribes user.
     *
     * @return \App\News
     * @return \Illuminate\Http\Response
     */
    public static function subscribe()
    {
        if (Auth::check()){
            return Auth::user()->update([
                'subscribe' => 1
            ]);
        }
        return abort(404);
    }

    /**
     * Unsubscribes user.
     *
     * @return \App\News
     * @return \Illuminate\Http\Response
     */
    public static function unsubscribe()
    {
        if (Auth::check()){
            return Auth::user()->update([
                'subscribe' => 0
            ]);
        }
        return abort(404);
    }
}
