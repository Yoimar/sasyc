<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Presupuesto
 *
 * @property integer $id
 * @property integer $solicitud_id
 * @property integer $requerimiento_id
 * @property integer $tipo_requerimiento_id
 * @property string $cod_item
 * @property string $cod_cta
 * @property integer $num_benef
 * @property integer $cantidad
 * @property float $monto
 * @property string $estatus
 * @property integer $id_doc_proc
 * @property integer $id_sol_sum
 * @property integer $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Solicitud $solicitud
 * @property-read \Requerimiento $requerimiento
 * @property-read \TipoRequerimiento $tipoRequerimiento
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereSolicitudId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereRequerimientoId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereTipoRequerimientoId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereCodItem($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereCodCta($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereNumBenef($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereCantidad($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereMonto($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereEstatus($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereIdDocProc($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereIdSolSum($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereVersion($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Presupuesto whereUpdatedAt($value) 
 */
class Presupuesto extends BaseModel {

    protected $table = "presupuestos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'solicitud_id', 'requerimiento_id', 'tipo_requerimiento_id', 'cod_item', 'cod_cta', 'num_benef', 'cantidad', 'monto', 'estatus', 'id_doc_proc', 'id_sol_sum',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'solicitud_id' => 'required|integer',
        'requerimiento_id' => 'required|integer',
        'tipo_requerimiento_id' => 'required|integer',
        'cod_item' => 'required',
        'cod_cta' => 'required',
        'num_benef' => 'required|integer',
        'cantidad' => 'required|integer',
        'monto' => 'required',
        'estatus' => 'required',
        'id_doc_proc' => 'required|integer',
        'id_sol_sum' => 'required|integer',
    ];

    protected function getPrettyFields() {
        return [
            'solicitud_id' => 'Solicitud',
            'requerimiento_id' => 'Requerimiento',
            'tipo_requerimiento_id' => 'Tipo de requerimiento',
            'cod_item' => 'Ítem',
            'cod_cta' => 'Cuenta',
            'num_benef' => 'Beneficiario',
            'cantidad' => 'Cantidad',
            'monto' => 'Monto',
            'estatus' => 'Estatus',
            'id_doc_proc' => 'IdDoc proc',
            'id_sol_sum' => 'IdSol sum',
        ];
    }

    protected function getPrettyName() {
        return "presupuestos";
    }

    /**
     * Define una relación pertenece a Solicitud
     * @return Solicitud
     */
    public function solicitud() {
        return $this->belongsTo('Solicitud');
    }

    /**
     * Define una relación pertenece a Requerimiento
     * @return Requerimiento
     */
    public function requerimiento() {
        return $this->belongsTo('Requerimiento');
    }

    /**
     * Define una relación pertenece a TipoRequerimiento
     * @return TipoRequerimiento
     */
    public function tipoRequerimiento() {
        return $this->belongsTo('TipoRequerimiento');
    }

}