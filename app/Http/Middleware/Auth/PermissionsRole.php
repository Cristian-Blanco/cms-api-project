<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Form;

class PermissionsRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //Get the current route
        $route = $request->route()->getName();
        $method = $request->method();
        // Get the user
        $user = Auth::user();

        //Verified the route with forms
        $role = $user->roles()->whereHas('forms', function ($query) use ($route) {
            $query->where('route', $route);
        })->first();

        if (!$role) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get the permissions with rol
        $permissions = $role->permissions->pluck('name');

        // Check if the role has the necessary permissions for the requested method
        $requiredPermissions = $this->getRequiredPermissionsForMethod($method);
        
        if (!$this->hasRequiredPermissions($permissions, $requiredPermissions)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }

    private function getRequiredPermissionsForMethod($method)
    {
        $permissionsMapping = [
            'GET' => ['read'],
            'POST' => ['create'],
            'PUT' => ['update'],
            'DELETE' => ['delete'],
        ];

        return $permissionsMapping[$method] ?? [];
    }

    private function hasRequiredPermissions($permissions, $requiredPermissions)
    {
        // Verificar si el usuario tiene los permisos necesarios
        return collect($requiredPermissions)->every(function ($permission) use ($permissions) {
            return $permissions->contains($permission);
        });
    }
}
