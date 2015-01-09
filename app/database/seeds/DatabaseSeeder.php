<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();
        $this->call('ConfiguracionSeeder');
        $this->call('NivelAcademicoTableSeeder');
        $this->call('OrganismoTableSeeder');
        $this->call('ParentescoTableSeeder');
        $this->call('RecepcionTableSeeder');
        $this->call('ReferenteTableSeeder');
        $this->call('TenenciaTableSeeder');
        $this->call('TipoAyudaTableSeeder');
        $this->call('TipoViviendaTableSeeder');
    }

}
