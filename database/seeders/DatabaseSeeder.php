<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = new User;
        $user->name = 'Admin';
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->role = 'admin';
        $user->save();

        $category = new Category();
        $category->title = 'Abstract';
        $category->slug = 'abstract';
        $category->save();


        $category = new Category();
        $category->title = 'Animals';
        $category->slug = 'animals';
        $category->save();


        $category = new Category();
        $category->title = 'Fashion';
        $category->slug = 'fashion';
        $category->save();


        $category = new Category();
        $category->title = 'food';
        $category->slug = 'Food';
        $category->save();


        $category = new Category();
        $category->title = 'Nature';
        $category->slug = 'nature';
        $category->save();


        $category = new Category();
        $category->title = 'sport';
        $category->slug = 'Sport';
        $category->save();


        $category = new Category();
        $category->title = 'Travel';
        $category->slug = 'travel';
        $category->save();

        $category = new Category();
        $category->title = 'People';
        $category->slug = 'people';
        $category->save();

        $category = new Category();
        $category->title = 'Document';
        $category->slug = 'document';
        $category->save();

    }
}
