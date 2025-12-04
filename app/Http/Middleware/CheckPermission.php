<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Split permission into module and action (e.g., "fisherfolk.view")
        [$module, $action] = explode('.', $permission);

        // Check if user has the required permission
        if (!auth()->user()->hasPermission($module, $action)) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
