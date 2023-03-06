<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeLdapRequest;
use App\Models\Ldap;
use Illuminate\Http\Request;

class LdapController extends Controller
{
    private $model;

    public function __construct(Ldap $ldap)
    {
        $this->model = $ldap;
    }

    public function regist(Request $request)
    {
        try {
            //ko cho user tự chỉ định ldap_id , mà sẽ để server generate
            $params = $request->except('ldap_id');
            $ldap_id = array('ldap_id' => $request->ldap_id);
            $ldap = $this->model->updateOrCreate($ldap_id, $params);

        } catch (\Exception $e) {
            return $e->getMessage();

        }
        return response()->json([
            'data' => $ldap,
            'status' => '200'

        ]);
    }

    public function delete(ChangeLdapRequest $request)
    {
        try {
            return $this->model->find($request->ldap_id)->delete();

        } catch (\Exception $e) {
            return $e->getMessage();

        }

    }

    public function deleteMulti($ids)
    {
        try {
            $this->model->whereIn('ldap_id', $ids)->get()->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
