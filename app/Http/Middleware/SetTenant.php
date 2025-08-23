<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class SetTenant
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); // demo.sekolyapp.com ou sekolyapp.com
        $parts = explode('.', $host);

        // Vérifier si c’est bien un sous-domaine (ex: demo.sekolyapp.com)
        if (count($parts) > 2) {
            $subdomain = $parts[0];

            // Charger le tenant
            $tenant = Tenant::where('subdomain', $subdomain)->first();

            if (! $tenant) {
                abort(404, 'Tenant not found');
            }

            // Partager dans l’app
            app()->instance('tenant', $tenant);
        }

        return $next($request);
    }
}
