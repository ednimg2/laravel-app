@extends('layout')

@section('content')

    <h1>User roles</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h2>User roles only active</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles()->active()->get() as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h2>User roles with not active attr</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles()->where('active', '=', 0)->get() as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h2>User roles with where like condition</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles()->where('name', 'like', '%admin%')->get() as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>


    <hr>
    <h2>Users with roles</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_with_roles as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h2>Users with roles</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_with_admin_roles as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>


    <hr>
    <h2>Users without roles</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($user_without_roles as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>



    <hr>
    <h2>Users with roles count</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Roles count</th>
            <th>Admin roles count</th>
            <th>Active roles count</th>
            <th>Roles</th>
        </tr>
        @foreach($user_with_counts as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->kiekis }}</td>
                <td>{{ $user->admin_count }}</td>
                <td>{{ $user->active_roles_count }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h1>User B2B with query builder</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_b2b_with_query_builder as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h1>User B2B with SCOPE</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_b2b_with_scope as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>


    <hr>
    <h1>User B2C with SCOPE</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_b2c_with_scope as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h1>User AdHoc with SCOPE</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Roles</th>
        </tr>
        @foreach($users_adhoc_with_scope as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }} |
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>

@endsection
