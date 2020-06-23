<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->integer('reference_id')->unsigned()->change();
            $table->string('reference', 255)->change();
        });

        Schema::table('slugs', function (Blueprint $table) {
            $table->renameColumn('reference', 'reference_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->renameColumn('reference_type', 'reference');
        });

        Schema::table('slugs', function (Blueprint $table) {
            $table->integer('reference_id')->change();
            $table->string('reference', 120)->change();
        });
    }
}
