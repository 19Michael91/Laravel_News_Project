<?php

namespace App;

use App\Category;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'visit_count', 'category_id'
    ];

    public static function getAllNews()
    {
        return self::all();
    }

    /**
     * Get news by id.
     *
     * @param  integer  $id
     * @return \App\News
     */
    public static function getNewsById(int $id)
    {
        return self::find($id);
    }

    /**
     * Get news order by visit count and paginate.
     *
     * @param  integer  $count
     * @return \App\News
     */
    public static function getOrderByVisitPaginateNews(int $count)
    {
        return self::orderBy('visit_count', 'DESC')->paginate($count);
    }

    /**
     * Get news by categories and order by visit count and paginate.
     *
     * @param  integer  $count
     * @param  \App\Category  $category
     * @return \App\News
     */
    public static function getNewsByCategoryPaginate(Category $category, int $count = 5)
    {
        return self::where('category_id', $category->id)->orderBy('visit_count', 'DESC')->paginate($count);
    }

    /**
     * Get news by title.
     *
     * @param  string  $title
     * @return \App\News
     */
    public static function getNewsByTitle(string $title)
    {
        return self::where('title', 'like', '%'. $title .'%' )->get();
    }

    /**
     * Get news by text.
     *
     * @param  string $text
     * @return \App\News
     */
    public static function getNewsByText(string $text)
    {
        return self::where('text', 'like', '%'. $text .'%' )->get();
    }

    /**
     * Get category related with news.
     *
     * @return \App\News
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Checks if exists news.
     *
     * @param  \App\News
     * @return \Illuminate\Http\Response
     */
    public static function isExistsNews($news)
    {
        if (null == $news) {
            return abort(404);
        }
    }

    /**
     * Update visit count.
     *
     * @return void
     */
    public function incrementVisitCount()
    {
        $this->update([
            'visit_count' => $this->visit_count + 1
        ]);
    }

    /**
     * Checks if news is favourite.
     *
     * @return boolean
     */
    public function isFavorite()
    {
        $favorite = Favorite::where('news_id' , $this->id)
                            ->where('user_id', Auth::user()->id)
                            ->first();
        if (!$favorite) {
            return false;
        }
        return true;
    }

    /**
     * Get favourite news.
     *
     * @param integer $count
     * @return \App\Favorite
     * @return \Illuminate\Http\Response
     */
    public static function getFavoritesNews(int $count)
    {
        if (Auth::check())
        {
            return Auth::user()->favorites()->paginate($count);
        }
        return abort(404);
    }

    /**
     * Add news to database.
     *
     * @param Illuminate\Http\Request
     * @return \App\News
     */
    public static function storeNews(Request $request)
    {
        return self::create([
            'title'         => $request->get('title'),
            'text'          => $request->get('text'),
            'category_id'   => $request->get('category')
        ]);
    }

}
