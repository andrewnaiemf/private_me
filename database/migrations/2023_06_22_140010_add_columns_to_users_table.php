<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('device_token')->nullable()->after('id');
            $table->string('email')->nullable(false)->change();
			$table->boolean('verified')->default(false)->after('phone');
			$table->boolean('active')->default(false)->after('verified');
			$table->boolean('terms')->default(false)->after('active');
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
            $table->longText('device_token');
            $table->string('email');
			$table->boolean('verified');
			$table->boolean('active');
        });
    }
}
