<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authUser = Auth::user();
        $targetUserId = $request->route('user_id'); // sesuai param di route
        $targetUser = User::find($targetUserId);

        if (!$targetUser) {
            abort(404, 'User not found');
        }

        $canChat = (
            ($authUser->hasRole('customer') && $targetUser->hasRole('admin')) ||
            ($authUser->hasRole('admin') && $targetUser->hasRole('customer'))
        );

        if (!$canChat) {
            abort(403, 'Unauthorized to chat with this user.');
        }

        return $next($request);
    }
}
