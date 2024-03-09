<?php

namespace App\Http\Controllers\CRUD\RoleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateResource implements CRUD
{
    public function resource(Request $request)
    {
        DB::beginTransaction();
        try {

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