<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Book;
use App\Models\BookComment;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'email' => 'test@test.test',
            'password' => Hash::make('12345678')
        ]);

        User::factory(1)->create([
            'email' => 'test@test2.test',
            'password' => Hash::make('123456789')
        ]);

        $admins = User::factory(1)->create([
            'email' => 'admin@admin.admin',
            'password' => Hash::make('admin'),
            'role' => User::ROLE_ADMIN
        ]);
        /** @var User $admin */
        $admin = $admins->first();

        $managers = User::factory(1)->create([
            'email' => 'manager@manager.manager',
            'password' => Hash::make('manager'),
            'role' => User::ROLE_CONTENT_MANAGER
        ]);
        $manager = $managers->first();


        //One to one exmaple
        $blogs = Blog::factory(1)->create();
        $blog = $blogs->first();
        $blog->user()->associate($admin);
        $blog->save();

        $awards = Award::factory(1)->create(['name' => 'test award']);
        /** @var Award $award */
        $award = $awards->first();
        $award->blog()->associate($blog);
        $award->save();

        // One to many example
        $blogs = Blog::factory(5)->create();

        $users = User::factory(1)->create([
            'email' => 'author@author.author',
            'password' => Hash::make('author')
        ]);

        $user = $users->first();

        /** @var Blog $blog */
        foreach ($blogs as $blog) {
            $blog->user()->associate($user);
            $blog->save();
        }

        //Many to many
        $roleAdmins = Role::factory(1)->create(['name' => 'ROLE_ADMIN']);
        $roleManager = Role::factory(1)->create(['name' => 'ROLE_MANAGER', 'active' => 0]);
        $roleUser = Role::factory(1)->create(['name' => 'ROLE_USER']);

        $admin->roles()->attach($roleAdmins->first());
        $admin->roles()->attach($roleManager->first());
        $admin->roles()->attach($roleUser->first());
        $admin->save();
        $manager->roles()->attach($roleManager->first());
        $manager->roles()->attach($roleUser->first());
        $manager->save();


        //for n+1

        $users = User::factory(1)->create([
            'email' => 'author1@author1.author',
            'password' => Hash::make('author')
        ]);

        $user = $users->first();
        $user->roles()->attach($roleAdmins->first());
        $user->save();

        //Coments
        $comment1 = new Comment();
        $comment1->text = 'testing';
        $comment1->rating = 5;
        $comment1->author = 'Author';
        $comment1->commentable()->associate($blog);
        $comment1->save();


        $books = Book::factory(1)->create();
        $book = $books->first();


        $comment2 = new Comment();
        $comment2->text = "book comment";
        $comment2->rating = 4;
        $comment2->author = "Author boook";
        $comment2->commentable()->associate($book);
        $comment2->save();


        $orders = Order::factory(1)->create();
        $order = $orders->first();


        $comment2 = new Comment();
        $comment2->text = "order comment";
        $comment2->rating = 4;
        $comment2->author = "Author order";
        $comment2->commentable()->associate($order);
        $comment2->save();
    }
}
