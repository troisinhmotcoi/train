<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;

//use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {

        $t = $request->company_type;
        if (empty($t))
            $t = 'all';
        switch ($t) {
            case ('all'):
                $all = $this->user->all();
                break;
            default:
                $all = DB::table('user_mst')
                    ->join('company_mst', function (JoinClause $join) use ($t) {
                        $join->on('user_mst.company_id', '=', 'company_mst.company_id')
                            ->where('company_mst.company_type', '=', intval($t));
                    })->get();

        }
        return $all;

    }

    public function update(Request $request)
    {
        try {
            $user = $this->user->findOrFail($request->user_id);
            $user_name = $request->user_name;
            $user_kana = $request->user_kana;
            $password = bcrypt($request->password);
            $user = $user->update(['user_name' => $user_name, 'user_kana' => $user_kana, 'password' => $password]);
            return response()->json([
                'data' => $user,
                'status' => '200'

            ]);
        } catch (ModelNotFoundException $e) {
            return ($e->getMessage());
        }

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

        $new = DB::table('user_mst')->insert($data);
    }

    public function search(Request $request)
    {
        $aData = $request->only('search[master][user_regist_date][start_eq]', 'search[master][user_regist_date][end_eq]', 'search[freeword]', 'search[master][company_id]',
            'search[master][auth_group_id]', 'search[master][user_lock_flag]');
        $q = $this->user;

        $aData = ['start_eq' => $request->search['master']['user_regist_date']['start_eq'],
            'end_eq' => $request->search['master']['user_regist_date']['end_eq'] ?? '',
            'auth_group_id' => $request->search['master']['auth_group_id'] ?? '',
            'user_lock_flag' => $request->search['master']['user_lock_flag'] ?? ''
        ];

        foreach ($aData as $k => $v) {
            switch ($k) {
                case ('start_eq'):
                    $q = $q->where('user_regist_date', '>', $v);
                case ('end_eq'):
                    $q = $q->where('user_regist_date', '<', $v);
                default:
                    $q = $q->where($k, $v);
            }
        }
        return ['data' => $q->get(), 'count' => count($q->get())];

    }

    public function libSearch(Request $request)
    {

        $users = QueryBuilder::for(User::class)
            ->allowedFilters([AllowedFilter::scope('start_eq'), AllowedFilter::scope('end_eq'), 'login_code'
            ])
            ->allowedSorts(['user_regist_date', 'login_code'])
            ->get();
        return $users;
    }

    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->delete();
        } // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) {
            return ($e->getMessage());
        }
    }
}
