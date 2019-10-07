<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all categories.
     *
     * @return \App\Category
     */
    public static function getAllCategories()
    {
        return self::all();
    }

    /**
     * Get category by id.
     *
     * @param  integer  $id
     * @return \App\Category
     */
    public static function getCategoryById(int $id)
    {
        return self::find($id);
    }

    /**
     * Checks if exists category.
     *
     * @param  \App\Category
     * @return \Illuminate\Http\Response
     */
    public static function isExistsCategory($category)
    {
        if (null == $category) {
            return abort(404);
        }
    }
}
