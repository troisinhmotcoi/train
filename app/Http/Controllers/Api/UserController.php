<?php

namespace App\Http\Controllers\Api;

use App\Enums\Paginate;
use App\Http\Requests\UserNonCreateRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;

//use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use function PHPUnit\Framework\throwException;

class UserController extends BaseController
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'exists:user_mst',
            'company_type' => 'in:1,2,3'
        ]);
        $data = $request->only('company_type', 'user_id');
        foreach ($data as $k => $v) {
            if ($v == NULL)
                unset($data[$k]);
        }
        $list = $this->model->select('*');
        try {
            foreach ($data as $k => $v) {
                switch ($k) {
                    case ('company_type'):
                        $list = $list->whereHas('company', function ($query) use ($v) {
                            $query->where('company_type', intval($v));
                        });
                        break;
                    case('user_id');
                        $list = $list->where('user_id', $v);
                        break;

                }
            }

        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());

        }
        return response()->json([
            'list' => $list->paginate(Paginate::user),
        ], 200);

    }

    public function update(UserNonCreateRequest $request)
    {
        try {
            $user = $this->model->findOrFail($request->user_id);
            $params = $request->only('user_name', 'user_kana', 'password');
            foreach ($params as $k => $v) {
                if ($v == NULL)
                    unset($params[$k]);
            };
            if (array_key_exists('password', $params))
                $params['password'] = bcrypt($params['password']);
            if (count($params) > 0)
                $user = $user->update($params);

        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());

        }
        return $this->responseSuccess($user);

    }

    public function create(UserRequest $request)
    {
        $data = $request->only("company_id", "section_id", "user_name", "user_kana",
            "user_mail", "user_sub_mail", "language_id", "login_code", "password", "auth_group_id", "approval_user_flag",
            "approval_method", "approval_rule", "ip_restriction_use_flag", "ldap_id",
            "file_transfer__template_id",
            "user_transfer__template_id",
            "password_change_date",
            "mistake_count", "user_lock_flag", "id_lock_flag", "id_lock_cookie", "id_lock_cookie_download_flag", "onetime_password_url", "onetime_password_time",
            "no_project_date", "user_regist_date", "last_login_date",
            "inviting_mail_flag", "revoke_flag", "regist_user_id", "update_user_id",
            "regist_date", "update_date", "saml_id",
            "file_share_approval_flag", "file_transfer_approval_flag",
            "user_transfer_approval_flag",
            "file_transfer_auto_bcc",
            "file_transfer_auto_bcc_other_mail",
            "win_app_ip_restriction_use_flag",
            "win_app_approval_flag",
            "win_app_approval_method",
            "win_app_approval_rule",
            "self_approval_flag"
        );
        $data['password'] = bcrypt($data['password']);
        try {
            $new = $this->model->create($data);

        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());
        }
        return $this->responseSuccess($new);

    }

    public function search(UserNonCreateRequest $request)
    {
        $aData = $request->only('start_eq', 'end_eq', 'freeword', 'company_id',
            'auth_group_id', 'user_lock_flag', 'login_code');
        $search = $this->model->select('*');
        foreach ($aData as $k => $v) {
            if ($v == NULL)
                unset($aData[$k]);
        }
        try {
            foreach ($aData as $k => $v) {
                switch ($k) {
                    case ('start_eq'):
                        $search = $search->where('user_regist_date', '>', $v);
                        break;
                    case ('end_eq'):
                        $search = $search->where('user_regist_date', '<', $v);
                        break;
                    case ('freeword'):
                        $search = $search->Where(function ($query) use ($v) {
                            $query->orwhere('user_name', 'like', '%' . $v . '%')
                                ->orWhere('user_kana', 'like', '%' . $v . '%')
                                ->orWhere('user_mail', 'like', '%' . $v . '%')
                                ->orWhere('user_sub_mail', 'like', '%' . $v . '%')
                                ->orWhere('login_code', 'like', '%' . $v . '%');
                        });
                        break;
                    default:
                        $search = $search->where($k, $v);
                        break;
                }
            }

        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());
        }
        $result = $search
            ->orderBy('user_name')
            ->orderBy('login_code')
            ->paginate(Paginate::user);
        return response(['data' => $result], 200);

    }

    public function libSearch(UserNonCreateRequest $request)
    {
        try {
            $users = QueryBuilder::for(User::class)
                ->allowedFilters([AllowedFilter::scope('start_eq'), AllowedFilter::scope('end_eq'), 'login_code'
                ])
                ->allowedSorts(['user_regist_date', 'login_code'])
                ->paginate(Paginate::user);
        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());
        }

        return response(['data' => $users, 'count' => count($users)], 200);
    }

    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->delete();
        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());
        }
        return $this->responseSuccess($user);

    }

    public function changePassword(Request $request)
    {
        try {
            $this->validate($request, ['current_pw' => 'required', 'expect_pw' => 'required|different:current_pw', 'user_id' => 'required|exists:user_mst,user_id']);
            $user = User::findOrFail($request->user_id);
            $check = password_verify($request->current_pw, $user->password);
            if ($check) {
                $password = bcrypt($request->expect_pw);
                $user = $user->update(['password' => $password]);

            } else
                throw new \Exception('current password is incorrect');

        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage());

        }
        return $this->responseSuccess($user);

    }

    public function loginRestrict(Request $request)
    {
        try {
            $this->validate($request, ['id_lock_flag' => 'required|in:0,1', 'user_id' => 'required|exists:user_mst,user_id']);
            $user = User::findOrFail($request->user_id);
            $value = $request->id_lock_flag;
            $user->update(['id_lock_flag' => $value]);

        } catch (\Exception $exception) {
            return $this->responseFail($exception->getMessage());

        }
        return $this->responseSuccess();
    }


}
