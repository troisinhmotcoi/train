<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(1)->create();

         \App\Models\User::factory()->create([
             "company_id" => "0002",
             "section_id" => null,
             "user_name" => "test",
             "user_kana" => "test",
             "user_mail" => "m-truong2@test41.com",
             "user_sub_mail" => null,
             "language_id" => "01",
             "login_code" => "test",
             "password" => bcrypt('lovecat'),
             "auth_group_id" => "001",
             "approval_user_flag" => 1,
             "approval_method" => 4,
             "approval_rule" => 1,
             "ip_restriction_use_flag" => 0,
             "ldap_id" => null,
             "file_transfer_default_template_id" => null,
             "user_transfer_default_template_id" => null,
             "password_change_date" => "2021-04-05T02:06:16.000Z",
             "mistake_count" => 0,
             "user_lock_flag" => 0,
             "id_lock_flag" => 0,
             "id_lock_cookie" => null,
             "id_lock_cookie_download_flag" => 0,
             "onetime_password_url" => null,
             "onetime_password_time" => null,
             "no_project_date" => null,
             "user_regist_date" => "2018-12-13T03:48:36.165Z",
             "last_login_date" => "2023-02-21T03:08:28.072Z",
             "inviting_mail_flag" => 0,
             "revoke_flag" => 0,
             "regist_user_id" => "00000001",
             "update_user_id" => "00000001",
             "regist_date" => "2018-12-13T03:48:36.165Z",
             "update_date" => "2023-02-21T03:08:28.000Z",
             "saml_id" => null,
             "file_share_approval_flag" => 1,
             "file_transfer_approval_flag" => 1,
             "user_transfer_approval_flag" => 1,
             "file_transfer_auto_bcc" => null,
             "file_transfer_auto_bcc_other_mail" => null,
             "win_app_ip_restriction_use_flag" => 1,
             "win_app_approval_flag" => 1,
             "win_app_approval_method" => 1,
             "win_app_approval_rule" => 1,
             "self_approval_flag" => 1         ]);
    }
}
