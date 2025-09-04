<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToZonasTable extends Migration
{
    public function up()
    {
        Schema::table('zonas', function (Blueprint $table) {
            $table->string('tipo')->default('zona');
        });
    }

    public function down()
    {
        Schema::table('zonas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
