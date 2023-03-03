<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_mst', function (Blueprint $table) {
            $table->id('option_id');
            $table->text('logo_login_ext')->default('png');
            $table->text('logo_login_e_ext')->default('png');
            $table->text('logo_header_ext')->default('png');
            $table->text('top_background_color')->default('#F2F2F2');
            $table->text('header_background_color')->default('#0094E2');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
