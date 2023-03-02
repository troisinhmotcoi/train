<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address_book_mst';
    protected $primaryKey = 'address_book_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [
        'address_book_id'
    ];

}
