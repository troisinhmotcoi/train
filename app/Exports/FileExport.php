<?php

namespace App\Exports;

//use App\Models\User;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FileExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $user_id;

    public function __construct($user_id = null)
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
        $headers = ['user_id',
            'company_id',
            'section_id',
            'user_name',
            'user_kana',
            'user_mail',
            'user_sub_mail',
            'language_id',
            'login_code',
            'auth_group_id',
            'approval_user_flag',
            'approval_method',
            'approval_rule',
            'ip_restriction_use_flag',
            'ldap_id',
            'file_transfer_default_template_id',
            'user_transfer_default_template_id',
            'password_change_date',
            'mistake_count',
            'user_lock_flag',
            'id_lock_flag',
            'id_lock_cookie',
            'id_lock_cookie_download_flag',
            'onetime_password_url',
            'onetime_password_time',
            'no_project_date',
            'user_regist_date',
            'last_login_date',
            'inviting_mail_flag',
            'revoke_flag',
            'regist_user_id',
            'update_user_id',
            'regist_date',
            'update_date',
            'saml_id',
            'file_share_approval_flag',
            'file_transfer_approval_flag',
            'user_transfer_approval_flag',
            'file_transfer_auto_bcc',
            'file_transfer_auto_bcc_other_mail',
            'win_app_ip_restriction_use_flag',
            'win_app_approval_flag',
            'win_app_approval_method',
            'win_app_approval_rule',
            'self_approval_flag',
            'deleted_at'];
        return $headers;
    }

    public function columnWidths(): array
    {
        $keys = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU');
        $arr = array_fill_keys($keys, 25);
        return $arr;
    }
}
