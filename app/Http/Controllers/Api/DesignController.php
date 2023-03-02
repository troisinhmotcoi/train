<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignRequest;
use App\Models\Design;
use http\Exception;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function __construct(Design $design)
    {
        $this->model = $design;
    }

    public function registDesign(DesignRequest $request)
    {
        try {
            $params = $request->only('logo_login_ext', 'logo_login_e_ext', 'logo_header_ext', 'top_background_color', 'header_background_color');
            $design = $this->model->updateOrInsert(['option_id' => $request->option_id], $params);
            return response()->json([
                'data' => $design,
                'status' => '200'

            ]);
        } catch (\Exception $e) {
            return $e->getMessage();

        }


    }
}
