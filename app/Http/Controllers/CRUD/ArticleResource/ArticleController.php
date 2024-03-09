<?php

namespace App\Http\Controllers\CRUD\ArticleResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CRUD\ArticleResource\Services\CreateResource;
use App\Http\Controllers\CRUD\ArticleResource\Services\ReadResource;
use App\Http\Controllers\CRUD\ArticleResource\Services\UpdateResource;
use App\Http\Controllers\CRUD\ArticleResource\Services\DeleteResource;
use App\Http\Controllers\Crud\CRUDContext;

class ArticleController extends Controller
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
