<?php

class TipoAyudaTableSeeder extends Seeder {

    public function run() {
        $tipoayudas = array('Salud',
            'Económica');
        foreach ($tipoayudas as $tipoayuda) {
            TipoAyuda::create(array('nombre' => $tipoayuda, 'cod_acc_int' => '010101'));
        }
    }

}
