<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function responseFail($message)
    {
        return response()->json(['message' => $message], 400);

    }

    public function responseSuccess($data = null)
    {
        return response()->json(['message' => 'success', 'data' => $data], 200);
    }
}
