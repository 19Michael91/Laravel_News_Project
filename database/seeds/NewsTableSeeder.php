<?php

use App\News;
use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lorem = ' Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cum deleniti doloribus eaque et illo, 
        ipsum iure nobis omnis voluptatibus. Architecto consequatur dolor dolore doloribus ex iste nulla praesentium quidem?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cum deleniti doloribus eaque et illo, 
        ipsum iure nobis omnis voluptatibus. Architecto consequatur dolor dolore doloribus ex iste nulla praesentium quidem?';

        foreach (range(1, 30) as $number) {
            News::create([
                'title'         => 'title_' . $number,
                'text'          => 'text_' . $number . $lorem,
                'visit_count'   => $number,
                'category_id'   => $number == 5 || $number % 5 == 0 ? 5 : $number % 5
            ]);
        }
    }
}
