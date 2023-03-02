<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditableWord extends Model
{
    use HasFactory;
    protected $table = 'editable_word_mst';
    protected $primaryKey = ['editable_word_id','language_id'];
    public $timestamps = false;
}
