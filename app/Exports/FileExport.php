<?php

namespace App\Exports;

//use App\Models\User;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FileExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $user_id;

    public function __construct($user_id=null)
    {
        $this->user_id = $user_id;

    }

    public function collection()
    {
        if (isset($this->user_id))
            return collect(['data' => User::find($this->user_id)]);

        else
            return User::all();
    }

    //Thêm hàng tiêu đề cho bảng
    public function headings(): array
    {
        return ["user_id", "company_id", "section_id", "user_name", "user_kana", "user_mail", "user_sub_mail", "language_id", "login_code", "auth_group_id", "approval_user_flag",
            "approval_method", "approval_rule", ""];
    }

//    public function columnFormats(): array
//    {
//        return [
//            'user_id' => '00000000',
//            'company_id' => '0000',
//        ];
//    }
}
