<?php

class Usuario extends BaseModel implements SimpleTableInterface {

    protected $primaryKey = "id";

    /**
     * Tabla del modelo
     * @var string
     */
    protected $table = 'users';

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = array(
        'email', 'password', 'nombre', 'activated', 'departamento_id'
    );

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = array(
        'email' => 'required|max:100',
        'password' => 'required',
        'nombre' => 'required',
        'departamento_id' => ''
    );

    /**
     * Array clave valor que le asocia a un atributo del modelo una oración o una frase que describe al atributo.
     * Se usa para construir los mensajes de error.
     * @return array
     */
    protected function getPrettyFields() {
        return array(
            'email' => 'Login',
            'password' => 'Contraseña',
            'nombre' => 'Nombre',
            'nombregrupo' => 'Grupo',
            'activated' => '¿Activo?',
            'departamento_id' => 'Departamento',
            'activatedfor' => '¿Activo?'
        );
    }

    /**
     * Oración o palabra mas descriptiva del nombre de la tabla que maneja el modelo
     * 
     * @return string
     */
    public function getPrettyName() {
        return "Usuarios";
    }

    public function setPasswordAttribute($value) {
        if ($value != "") {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function getActivatedforAttribute() {
        return static::$cmbsino[$this->activated];
    }
    
    public function departamento(){
        return $this->belongsTo('Departamento');
    }

    public function grupos() {
        return $this->belongsToMany('Grupo', 'users_groups', 'user_id', 'group_id');
    }

    public function getNombregrupoAttribute() {
        $grupos = $this->grupos;
        if (count($grupos) == 0) {
            return "";
        }
        return $grupos[0]->name;
    }

    public function getIdgrupoAttribute() {
        $grupos = $this->grupos;
        if (count($grupos) == 0) {
            return "";
        }
        return $grupos[0]->id;
    }

    public static function puedeAcceder($permiso) {
        return Sentry::getUser()->hasAccess($permiso);
    }

    public function getTableFields() {
        return ['email', 'nombre', 'nombregrupo', 'activatedfor'];
    }

}
