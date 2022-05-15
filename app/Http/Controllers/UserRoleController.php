<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRoleController extends Controller
{
    public function index()
    {
        return view(
            'user_roles.index',
            [
                //gauti b2b
                'users_b2b_with_query_builder' => User::where('type', '=', User::TYPE_B2B)->get(),
                'users_b2b_with_scope' => User::b2b()->defaultSorting()->get(),
                'users_b2c_with_scope' => User::b2c()->reverseSorting()->get(),
                'users_adhoc_with_scope' => User::adHoc()->reverseSorting()->get(),

                'users' => User::all(),
                //Select user.* from users Left join user_role on users.id = user_role.user_id Where user_role.user_id is not null

                'users_with_roles' => User::has('roles')->get(),

                'users_with_admin_roles' => User::whereHas('roles', function (Builder $builder) {
                    $builder->where('name', 'like', '%admin%');
                })->get(),

                'user_without_roles' => User::whereDoesntHave('roles')->get(),

                'user_with_counts' => User::withCount(
                    [
                        'roles as kiekis',
                        'roles as admin_count' => function (Builder $builder) {
                            $builder->where('name', 'like', '%admin%');
                        },
                        'roles as active_roles_count' => function (Builder $builder) {
                            $builder->where('active', '=', '1');
                        }
                    ]
                )->get() //roles_count
            ]
        );
    }
}
