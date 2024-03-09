<?php

namespace App\Http\Controllers\CRUD\RoleResource\Services;

use App\Http\Controllers\CRUD\Interfaces\CRUD;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeleteResource implements CRUD, RecordOperations
{
    public function resource(Request $request)
    {
        if ($request->has('role_id')) {
            return $this->singleRecord($request->input('role_id'));
        } else {
            return $this->allRecords();
        }
    }

    public function singleRecord($id)
    {
        try {

        } catch (QueryException $ex) {
            Log::error('Query error RoleResource@delete:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error RoleResource@delete:singleRecord: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete u'], 500);
        }
    }

    public function allRecords()
    {
        try {

        } catch (QueryException $ex) {
            Log::error('Query error RoleResource@delete:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete q'], 500);
        } catch (\Exception $ex) {
            Log::error('unknown error RoleResource@delete:allRecords: - Line:' . $ex->getLine() . ' - message: ' . $ex->getMessage());
            return response()->json(['message' => 'delete u'], 500);
        }
    }
}