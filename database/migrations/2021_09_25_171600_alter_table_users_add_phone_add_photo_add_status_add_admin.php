<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddPhoneAddPhotoAddStatusAddAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('name');
            $table->string('phoneNumber')->nullable()->after('password');
            $table->integer('status')->default(1)->comment('1 - able to login, 0 - unable');
            $table->integer('admin')->default(0)->comment('1 - admin, 0 - guest');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('phoneNumber');
            $table->dropColumn('status');
            $table->dropColumn('admin');
        });
    }
}
