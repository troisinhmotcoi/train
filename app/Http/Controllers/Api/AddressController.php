<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;


class AddressController extends Controller
{
    public function edit(Request $request)
    {
        $this->validate($request, [
            'address_book_name' => 'required|max:200',
            'address_book_kana' => 'required|max:200',
            'address_book_mail' => 'required|max:200'

        ]);
        $data = $request->only('address_book_name', 'address_book_kana', 'address_book_mail', 'note');
        $address = Address::find($request->address_book_id);
        foreach ($data as $k => $v) {
            $address->$k = $v;
        }
        $address->save();
    }
}
