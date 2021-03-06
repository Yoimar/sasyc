<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Referente
 *
 * @property integer $id
 * @property string $nombre
 * @property string $cargo
 * @property integer $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Referente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Referente whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\Referente whereCargo($value)
 * @method static \Illuminate\Database\Query\Builder|\Referente whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\Referente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Referente whereUpdatedAt($value)
 * @property-read mixed $estatus_display
 */
class Referente extends BaseModel implements SimpleTableInterface {

    protected $table = "referentes";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre', 'cargo',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, 
     * y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'nombre' => 'required',
        'cargo' => 'required',
    ];

    protected function getPrettyFields() {
        return [
            'nombre' => 'Referido por',
            'cargo' => 'Cargo',
        ];
    }

    public function getPrettyName() {
        return "Referente";
    }
}
