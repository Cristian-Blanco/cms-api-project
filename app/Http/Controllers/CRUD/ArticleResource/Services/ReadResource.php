<?php

namespace App\Http\Controllers\CRUD\ArticleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use App\Http\Controllers\CRUD\Interfaces\RecordOperations;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ReadResource implements CRUD, RecordOperations
{
    public function resource(Request $request)
    {
        if ($request->has('article_id')) {
            return $this->singleRecord($request->input('article_id'));
        } else {
            return $this->allRecords();
        }
    }

    public function singleRecord($id)
    {
        try {
            return Article::find($id);
        } catch (QueryException $ex) {
            Log::error('Query error ArticleResource@read:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'read q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error ArticleResource@read:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'read u'], 500);
        }
    }

    public function allRecords($ids = [])
    {
        try {
            return Article::where('status', true)->paginate(6);
        } catch (QueryException $ex) {
            Log::error('Query error ArticleResource@read:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'read q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error ArticleResource@read:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'read u'], 500);
        }
    }
}