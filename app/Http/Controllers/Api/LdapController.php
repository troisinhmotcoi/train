<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeLdapRequest;
use App\Models\Ldap;
use Illuminate\Http\Request;

class LdapController extends BaseController
{

    public function __construct(Ldap $ldap)
    {
        parent::__construct($ldap);

    }

    public function regist(Request $request)
    {
        try {
            //ko cho user tự chỉ định ldap_id , mà sẽ để server generate
            $params = $request->except('ldap_id');
            $ldap_id = array('ldap_id' => $request->ldap_id);
            $ldap = $this->model->updateOrCreate($ldap_id, $params);

        } catch (\Exception $e) {
            $this->responseFail($e->getMessage());

        }
        return $this->responseSuccess($ldap);

    }

    public function delete(ChangeLdapRequest $request)
    {
        try {
            $del = $this->model->findOrFail($request->ldap_id);
            $del->delete();
        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());

        }
        return $this->responseSuccess();

    }

    public function deleteMulti($ids)
    {
        try {
            $this->model->whereIn('ldap_id', $ids)->get()->delete();
        } catch (\Exception $e) {
            $this->responseFail($e->getMessage());
        }

        return $this->responseSuccess();

    }
}
