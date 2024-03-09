<?php

namespace App\Http\Controllers\CRUD\ArticleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UpdateResource implements CRUD
{
    public function resource(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $article = Article::findOrFail($request->input('role_id'));

            $article->title = $request->input('title');
            $article->description = $request->input('description');
            $article->status = $request->input('status');

            if ($request->hasFile('image')) {
                Storage::disk('s3')->delete($article->image);
    
                $imagePath = Storage::disk('s3')->putFile('images', $request->file('image'));
                $article->image = $imagePath;
            }
    
            if ($request->hasFile('video')) {
                Storage::disk('s3')->delete($article->video);
                
                $videoPath = Storage::disk('s3')->putFile('videos', $request->file('video'));
                $article->video = $videoPath;
            }

            $article->save();
            DB::commit();
            return response()->json(['message' => 'Successful']);
        } catch (QueryException $ex) {
            DB::rollback();
            Log::error('Query error RoleResource@update: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'update q'], 500);
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error('unknown error RoleResource@update: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'update u'], 500);
        }
    }
}