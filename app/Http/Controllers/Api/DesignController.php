<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignRequest;
use App\Models\Design;
use http\Exception;
use Illuminate\Http\Request;

class DesignController extends BaseController
{
    public function __construct(Design $design)
    {
        parent::__construct($design);
    }

    public function registDesign(DesignRequest $request)
    {
        try {
            $params = $request->only('logo_login_ext', 'logo_login_e_ext', 'logo_header_ext', 'top_background_color', 'header_background_color');
            $op_id = array('option_id' => $request->option_id);

            $design = $this->model->updateOrCreate($op_id, $params);

        } catch (\Exception $e) {
          return  $this->responseFail($e->getMessage());


        }
        return $this->responseSuccess($design);


    }
}
