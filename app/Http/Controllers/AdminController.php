<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreNewsRequest;
use App\User;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Get all news.
     *
     * @return \App\News
     * @return \Illuminate\Http\Response
     */
    public function getAllNews()
    {
        User::isAdmin();
        $news = News::getOrderByVisitPaginateNews(5);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Delete news.
     *
     * @param integer $news_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNews(int $news_id)
    {
        User::isAdmin();
        $news_to_delete = News::getNewsById($news_id);
        News::isExistsNews($news_to_delete);
        $news_to_delete->delete();
        $news = News::getOrderByVisitPaginateNews(5);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show form to create news.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNews()
    {
        User::isAdmin();
        $categories = Category::getAllCategories();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Create news.
     *
     * @param App\Http\Requests\StoreNewsRequest
     * @return \Illuminate\Http\Response
     */
    public function storeNews(StoreNewsRequest $request)
    {
        $categories = Category::getAllCategories();
        $validated = $request->validated();
        if ($validated->fails()) {
            $errors = $validated->getMessageBag();
            return view('admin.news.create', compact('categories', 'errors'));
        }
        $news = News::storeNews($request);
        User::sendEmailToAllSubscribers($news);
        return redirect()->route('admin.index');
    }
}
