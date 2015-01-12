<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoNacionalidad
 *
 * @author Nadin Yamani
 * @property integer $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\TipoNacionalidad whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\TipoNacionalidad whereNombre($value) 
 * @method static \Illuminate\Database\Query\Builder|\TipoNacionalidad whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\TipoNacionalidad whereUpdatedAt($value) 
 */
class TipoNacionalidad extends BaseModel {

    protected $table = "tipo_nacionalidades";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre', 
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'nombre'=>'required', 

    ];
    
    protected function getPrettyFields() {
        return [
            'nombre'=>'nombre', 

        ];
    }

    protected function getPrettyName() {
        return "tipo_nacionalidades";
    }

    

}
