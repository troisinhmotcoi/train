<?php
namespace App\Http\Controllers\Api;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $user;
public function __construct(User $user)
{$this->user =$user;


}
public function index(Request $request) {
$all =DB::table('user_mst')
    ->join('company_mst', function (JoinClause $join) {
        $join->on('user_mst.company_id', '=', 'company_mst.company_id')
            ->where('company_mst.company_type', '=', 3);
    })->get();
        return $all;
}
}
