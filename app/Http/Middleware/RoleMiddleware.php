<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RoleMiddleware
{
    private const ROLE_MAP = [
        User::ROLE_ADMIN => [User::ROLE_CONTENT_MANAGER, User::ROLE_USER],
        User::ROLE_CONTENT_MANAGER => [User::ROLE_USER],
        User::ROLE_USER => [],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        /** @var User $user */
        $user = Auth::user();
        // 1. tikrinsim ar turim vartotoja
        // 2. tikrinsim ar turim tam tikra role
        // 3. jei nieko neturim access deneind
        if (!$user) {
            throw new AccessDeniedHttpException('Vartotojas neegzistuoja');
        }


        //TIkrinimas
        //1. Jeigu roles machina, t.y. turim tokia pat vartotojo rolę, kokią turi ir routas
        //2. Ar vartotojo role suteikia papildomų rolių. ir ar tos papildomos rolės yra tokios kaip nurodyta route role


        $additionalUserRoles = self::ROLE_MAP[$user->role];

        if ($user->role === $role || in_array($role, $additionalUserRoles)) {
            return $next($request);
        } else {
            throw new AccessDeniedHttpException('Invalid role');
        }
    }
}
