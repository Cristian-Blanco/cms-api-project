<?php

namespace App\Http\Controllers\CRUD\ArticleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use App\Http\Controllers\CRUD\Interfaces\RecordOperations;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class DeleteResource implements CRUD, RecordOperations
{
    public function resource(Request $request)
    {
        if ($request->has('article_id')) {
            return $this->singleRecord($request->input('article_id'));
        } else {
            return $this->allRecords($request->input('article_ids'));
        }
    }

    public function singleRecord($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();
            return response()->json(['message' => 'Role deleted successfully']);
        } catch (QueryException $ex) {
            Log::error('Query error ArticleResource@delete:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error ArticleResource@delete:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete u'], 500);
        }
    }

    public function allRecords($ids = [])
    {
        try {
            foreach ($ids as $articleId) {
                $article = Article::findOrFail($articleId);
                $article->delete();
            }
            return response()->json(['message' => 'Roles deleted successfully']);
        } catch (QueryException $ex) {
            Log::error('Query error ArticleResource@delete:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error ArticleResource@delete:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete u'], 500);
        }
    }
}