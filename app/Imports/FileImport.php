<?php


namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class FileImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    protected $arr = ["company_id", "section_id", "user_name", "user_kana",
        "user_mail", "user_sub_mail", "language_id", "login_code", "password", "auth_group_id", "approval_user_flag",
        "approval_method", "approval_rule", "ip_restriction_use_flag", "ldap_id",
        "file_transfer_default_template_id",
        "user_transfer_default_template_id",
        "password_change_date",
        "mistake_count", "user_lock_flag", "id_lock_flag", "id_lock_cookie", "id_lock_cookie_download_flag", "onetime_password_url", "onetime_password_time",
        "no_project_date", "user_regist_date", "last_login_date",
        "inviting_mail_flag", "revoke_flag", "regist_user_id", "update_user_id",
        "regist_date", "update_date", "saml_id",
        "file_share_approval_flag", "file_transfer_approval_flag",
        "user_transfer_approval_flag",
        "file_transfer_auto_bcc",
        "file_transfer_auto_bcc_other_mail",
        "win_app_ip_restriction_use_flag",
        "win_app_approval_flag",
        "win_app_approval_method",
        "win_app_approval_rule",
        "self_approval_flag"];
    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;

        $mix = array_combine($this->arr, $row);
        $mix['password'] = bcrypt($mix['password']);
        return new User(
            $mix
        );
    }
}
