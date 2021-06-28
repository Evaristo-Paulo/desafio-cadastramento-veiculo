<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tip_versions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tip_id')->unsigned();
            $table->foreign('tip_id')->references('id')->on('tips')->onDelete('cascade');
            $table->bigInteger('version_id')->unsigned();
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tip_versions');
    }
}
