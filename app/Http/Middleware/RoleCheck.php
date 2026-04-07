<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $role = trim(strtolower(session('role_name')));

        if (!in_array($role, array_map('strtolower', $roles))) {
            return redirect()->route('index')->with('error', 'Access forbidden');
        }

        return $next($request);
    }
}
