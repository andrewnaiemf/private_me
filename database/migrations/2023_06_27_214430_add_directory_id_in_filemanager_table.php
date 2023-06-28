<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDirectoryIdInFilemanagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('filemanager', function (Blueprint $table) {
            $table->unsignedBigInteger('directory_id')->nullable()->after('user_id');

            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filemanager', function (Blueprint $table) {
            $table->dropForeign(['directory_id']);
            $table->dropColumn('directory_id');
        });
    }
}
