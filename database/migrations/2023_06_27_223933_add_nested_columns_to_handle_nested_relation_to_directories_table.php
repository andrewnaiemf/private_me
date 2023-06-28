<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNestedColumnsToHandleNestedRelationToDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directories', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('directory_type_id');
            $table->unsignedBigInteger('left')->nullable()->after('parent_id');
            $table->unsignedBigInteger('right')->nullable()->after('left');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directories', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('left');
            $table->dropColumn('right');
        });
    }
}
