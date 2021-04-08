<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        
        factory(App\Article::class,30)
        ->create();
        
        factory(App\Comment::class,15)
        ->create();

        factory(App\Like::class,15)
        ->create();
        
        $articles = App\Article::all();

        factory(App\Tag::class,5)->create()
        ->each(function($tag) use ($articles){
            $tag->articles()->attach(
                $articles->random(6,1)->pluck('id')->toArray()
            );
        });
    }
}
