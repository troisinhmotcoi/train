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
        try {
            $address = Address::findOrFail($request->address_book_id);
            foreach ($data as $k => $v) {
                $address->$k = $v;
            }
            $address->save();
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 400);
        }
        return response([
            'message' => 'success'
        ], 200);
    }

}
