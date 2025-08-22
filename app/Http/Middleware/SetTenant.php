<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class SetTenant
{
    public function handle($request, Closure $next)
    {
        // Récupérer le sous-domaine
        $host = $request->getHost(); // ex: ecole1.sekolypro.com
        $subdomain = explode('.', $host)[0];

        // Chercher le tenant
        $tenant = Tenant::where('subdomain', $subdomain)->first();

        if ($tenant) {
            app()->instance('tenant', $tenant);
        } else {
            // Optionnel : empêcher l'accès si tenant non trouvé
            abort(404, 'Tenant not found');
        }

        return $next($request);
    }
}
