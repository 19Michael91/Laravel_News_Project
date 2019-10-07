<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\News;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NewsController extends Controller
{
    /**
     * Display all news.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news       = News::getOrderByVisitPaginateNews(5);
        $categories = Category::getAllCategories();
        return view('news.index', compact('news', 'categories'));
    }

    /**
     * Get news by category.
     *
     * @param integer $category_id
     * @return \Illuminate\Http\Response
     */
    public function getNewsByCategory(int $category_id)
    {
        $category = Category::getCategoryById($category_id);
        Category::isExistsCategory($category);
        $news       = News::getNewsByCategoryPaginate($category);
        $categories = Category::getAllCategories();
        return view('news.category.index', compact('news', 'category', 'categories'));
    }

    /**
     * Get single news.
     *
     * @param integer $news_id
     * @return \Illuminate\Http\Response
     */
    public function getSingleNews(int $news_id)
    {
        $news = News::getNewsById($news_id);
        News::isExistsNews($news);
        $categories = Category::getAllCategories();
        $news->incrementVisitCount();
        return view('news.single.index', compact('news', 'categories'));
    }

    /**
     * Get search news by title and text.
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function searchNews(Request $request)
    {
        $search         = $request->get('search');
        $newsByTitle    = News::getNewsByTitle($search);
        $newsByText     = News::getNewsByText($search);;
        $news           = $newsByTitle->merge($newsByText);
        $categories     = Category::getAllCategories();
        return view('news.search.index', compact('news', 'categories', 'search'));
    }

    /**
     * Add news to favorite.
     *
     * @param integer $news_id
     * @return \Illuminate\Http\Response
     */
    public function addNewsToFavorite(int $news_id)
    {
        $news = News::getNewsById($news_id);
        News::isExistsNews($news);
        Favorite::addNews($news_id);
        return redirect()->back();
    }

    /**
     * Remove news from favorite.
     *
     * @param integer $news_id
     * @return \Illuminate\Http\Response
     */
    public function removeNewsFromFavorite(int $news_id)
    {
        $news = News::getNewsById($news_id);
        News::isExistsNews($news);
        Favorite::isExistsFavorites($news_id);
        $favorite = Favorite::getFavoriteByNewsId($news_id);
        $favorite->delete();
        return redirect()->back();
    }

    /**
     * Get favourites news.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFavoritesNews()
    {
        $favorites   = News::getFavoritesNews(5);
        $categories  = Category::getAllCategories();
        return view('news.favorite.index', compact('favorites', 'categories'));
    }

    /**
     * Subscribe user.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe()
    {
        User::subscribe();
        return redirect()->back();
    }

    /**
     * Unsubscribe user.
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe()
    {
        User::unsubscribe();
        return redirect()->back();
    }
}
