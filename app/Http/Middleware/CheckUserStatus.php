<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isSuspended()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Your account has been suspended. Please contact the administrator.');
            }

            if ($user->status === 'pending') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('warning', 'Your account is pending approval. Please wait for admin confirmation.');
            }
        }

        return $next($request);
    }
}
