<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session; // <-- Import the Session facade
    use Symfony\Component\HttpFoundation\Response;

    class CheckUserSession
    {
        /**
         * Handle incoming request.
         *
         * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
         */
        public function handle(Request $request, Closure $next): Response
        {
            if (!Session::has('admin_user')) {
                
                return redirect()->route('admin.login.form');
            }
            
            return $next($request);
        }
    }
    
