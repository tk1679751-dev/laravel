<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the two dedicated users: Alice and Bob
        $alice = User::factory()->alice()->create();
        $bob = User::factory()->bob()->create();
        
        $users = [$alice, $bob];

        // Create 5 predefined categories
        $categories = Category::factory()->count(5)->create();

        // Create 20 posts distributed between Alice and Bob
        $posts = collect();
        for ($i = 0; $i < 20; $i++) {
            $post = Post::factory()->create([
                'user_id' => $users[array_rand($users)]->id,
                'category_id' => $categories->random()->id,
            ]);
            $posts->push($post);
        }

        // Create 40 comments distributed across posts and users
        for ($i = 0; $i < 40; $i++) {
            Comment::factory()->create([
                'user_id' => $users[array_rand($users)]->id,
                'post_id' => $posts->random()->id,
            ]);
        }
    }
}
