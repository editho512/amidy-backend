<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'John Doe',
            'name' => 'kim',
            'email' => 'johndoe@example.com',
            'phone' => '+261325033378',
            'adresse' => 'Mangarivotra',
            'password' => bcrypt('password'),
            'type' => "Super administrator"
        ]);

        Tag::create([
            'name' => 'Perissable',
            'type' => 'article'
        ]);

        Tag::create([
            'name' => 'A la mode',
            'type' => 'article'
        ]);

        Tag::create([
            'name' => 'Sexy',
            'type' => 'article'
        ]);

        Tag::create([
            'name' => 'for baby',
            'type' => 'article'
        ]);

        Tag::create([
            'name' => 'Scammer',
            'type' => 'customer'
        ]);

        Category::create([
            'name' => 'Matériel informatique',
            'type' => 'article'
        ]);

        Category::create([
            'name' => 'mode et Fashion',
            'type' => 'article'
        ]);

        Category::create([
            'name' => 'Client VIP',
            'type' => 'customer'
        ]);
    }
}
