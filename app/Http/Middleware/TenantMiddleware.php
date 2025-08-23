<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); // ex: ecole1.sekolyapp.com
        $subdomain = explode('.', $host)[0]; // ecole1

        $tenant = Tenant::where('domain', $subdomain)->first();

        if (! $tenant) {
            abort(404, 'Tenant introuvable');
        }

        // On lie le tenant dans le container
        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
