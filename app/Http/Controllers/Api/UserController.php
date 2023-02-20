<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;

class UserController extends Controller
{
    private $user;
public function __construct(User $user)
{$this->user =$user;


}
public function index(Request $request) {
$all =$this->user::all();
        return $all;
}
}
