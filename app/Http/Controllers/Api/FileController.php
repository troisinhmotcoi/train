<?php

namespace App\Http\Controllers\Api;

use App\Exports\FileExport;
use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function export()
    {
        return Excel::download(new FileExport, 'user_csv.xlsx'); //download file export
        return Excel::store(new FileExport, 'user_csv.xlsx', 'disk-name'); //lưu file export trên ổ cứng
    }

    public function exportDetailExcel(Request $request)
    {
        try {
            $this->validate($request, ['user_id' => 'required|exists:user_mst,user_id']);

            $user = User::findOrFail($request->user_id);
            return Excel::download(new FileExport($user->user_id), $user->login_code . '.xlsx');
            return Excel::store(new FileExport($user->user_id), $user->login_code . '.xlsx', 'disk-name'); //lưu file export trên ổ cứng
        } catch (\Exception $e) {
            return response()->json(['fail' => $e->getMessage()], 404);
        }

    }

    public function import()
    {
        try {
            Excel::import(new FileImport, request()->file('data'));
            return response()->json('success', 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);

        }
    }

}
