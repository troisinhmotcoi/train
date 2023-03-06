<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ldap extends Model
{
    use HasFactory;
    protected $table = 'ldap_mst';
    protected $primaryKey = 'ldap_id';
    public $timestamps =false;
    public  $incrementing = false;
    protected $guarded = ['ldap_id'];

}
