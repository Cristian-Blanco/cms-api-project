<?php

namespace App\Http\Controllers\CRUD\ArticleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class CreateResource implements CRUD
{
    public function resource(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $article = Article::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
            ]);

            if ($request->hasFile('image')) {
                $imagePath = Storage::disk('s3')->putFile('images', $request->file('image'));
                $article->image = $imagePath;
            }

            if ($request->hasFile('video')) {
                $videoPath = Storage::disk('s3')->putFile('videos', $request->file('video'));
                $article->video = $videoPath;
            }

            $article->save();

            DB::commit();
            return response()->json(['message' => 'Successful']);
        } catch (QueryException $ex) {
            DB::rollback();
            Log::error('Query error RoleResource@create: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'create q'], 500);
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('unknown error RoleResource@create: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'create u'], 500);
        }
    }
}