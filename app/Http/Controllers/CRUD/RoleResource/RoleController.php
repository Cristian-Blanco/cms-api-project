<?php

namespace App\Http\Controllers\CRUD\RoleResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\CRUD\RoleResource\Services\CreateResource;
use App\Http\Controllers\CRUD\RoleResource\Services\ReadResource;
use App\Http\Controllers\CRUD\RoleResource\Services\UpdateResource;
use App\Http\Controllers\CRUD\RoleResource\Services\DeleteResource;
use App\Http\Controllers\Crud\CRUDContext;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        switch($request->method()){
            case 'POST':
                $strategy = new CRUDContext(new CreateResource());
                break;
            case 'GET':
                $strategy = new CRUDContext(new ReadResource());
                break;
            case 'PUT':
                $strategy = new CRUDContext(new UpdateResource());
                break;
            case 'DELETE':
                $strategy = new CRUDContext(new DeleteResource());
                break;
            default:
                return response()->json(['error' => 'Method not allowed']);
        }

        $execResource = $strategy->execResource($request);

        return $execResource;
    }
}
