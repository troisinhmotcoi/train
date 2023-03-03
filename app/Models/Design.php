<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $table = 'design_mst';

    protected $primaryKey = 'option_id';
    protected $fillable = ['logo_login_ext', 'logo_login_e_ext', 'logo_header_ext', 'top_background_color', 'header_background_color'];
    public $incrementing = true;
    public $timestamps =false;

}
