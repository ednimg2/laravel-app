<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Blog;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AwardController extends Controller
{
    public function index()
    {
        /**
         * 1. Gaunam award pagal id:
         *
         * Select id, name, blog_id from award where id = 1
         *
         * 2. Ieskom blog'o, kuriam priklauso award:
         *
         * Select title from blogs Where id = {blog_id}
         */
        $award = Award::find(1);

        var_dump('Award name: ' . $award->name);
        var_dump('Blog Name: ' . $award->blog->title);

        echo '<br>';

        $blog = Blog::find(1);

        var_dump('Blog Name: ' . $blog->title);
        var_dump('Award name: ' . $blog->award->name);

        return 'award_view';
    }

    public function userBlogs()
    {
        $blog = Blog::find(2);
        var_dump($blog->title);
        echo '<br>';

        var_dump($blog->user->id);
        echo '<br>';
        var_dump($blog->user->email);

        //pasiloadinti vartotoja
        //pasiziuret ar jis turi visus blogus priskirtus

        /** @var User $user */
        $user = User::find(5);

        /** @var Collection $list */
        $list = $user->blogs;

        foreach ($list as $blog) {
            echo 'BLOG TITLE: ' . $blog->title . '<br>';
        }

        return 'user_blogs';
    }

    public function userRoles()
    {
        /** @var User $admin */
        $admins = User::all();

        foreach ($admins as $admin) {
            foreach ($admin->roles as $role) {
                var_dump($role->name);
                echo '<br>';

                var_dump('AWARDS:');
                echo '<br>';
                var_dump($admin->awards->count());
                foreach ($admin->awards as $award) {
                    var_dump($award->name);
                }
            }
        }
    }

    public function comments()
    {
        $blog = Blog::find(6);
        echo 'Blog comment:';
        foreach ($blog->comments as $comment) {
            echo $comment->text . '</br>';
        }

        $order = Order::find(1);
        echo 'Order comment:';
        foreach ($order->comments as $comment) {
            echo $comment->text . '</br>';
        }
    }
}
