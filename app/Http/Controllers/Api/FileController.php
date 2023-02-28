<?php

namespace App\Http\Controllers\Api;

use App\Exports\FileExport;
use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user = User::findOrFail($request->user_id);
        $file = Excel::download(new FileExport($user->user_id), $user->login_code.'.xlsx');
        return $file;
        return Excel::store(new FileExport($user->user_id), $user->login_code.'.xlsx', 'disk-name'); //lưu file export trên ổ cứng

    }
}
