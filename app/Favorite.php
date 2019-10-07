<?php

namespace App;

use App\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'news_id'
    ];

    /**
     * Add news to favourive.
     *
     * @param  integer  $news_id
     * @return \App\Favorite
     * @return \Illuminate\Http\Response
     */
    public static function addNews(int $news_id)
    {
        if(Auth::check()) {
            return self::create([
                'news_id'   => $news_id,
                'user_id'   => Auth::user()->id
            ]);
        }
        return abort(404);
    }

    /**
     * Get favourites news by id.
     *
     * @param  integer  $news_id
     * @return \App\Favorite
     * @return \Illuminate\Http\Response
     */
    public static function getFavoriteByNewsId(int $news_id)
    {
        if (Auth::check()){
            $favorite = self::where('user_id', Auth::user()->id)
                ->where('news_id', $news_id)
                ->first();
            return $favorite;
        }
        return abort(404);
    }

    /**
     * Checks if exists favourites.
     *
     * @param  integer  $news_id
     * @return \Illuminate\Http\Response
     */
    public static function isExistsFavorites(int $news_id)
    {
        $favorite = self::getFavoriteByNewsId($news_id);
        if (null == $favorite) {
            return abort(404);
        }
    }


    /**
     * Receive related news
     *
     * @return \App\Favorite
     */
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
