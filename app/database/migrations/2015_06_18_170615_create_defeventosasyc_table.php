<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefeventosasycTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('defeventosasyc', function(Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_doc', 5);
            $table->string('tipo_evento', 3);
            $table->boolean('ind_aprueba_auto')->default(0);
            $table->boolean('ind_doc_ext')->default(0);
            $table->boolean('ind_ctas_adic')->default(0);
            $table->boolean('ind_reng_adic')->default(0);
            $table->boolean('ind_detcomp_adic')->default(0);
            $table->integer('version')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('defeventosasyc');
    }

}
