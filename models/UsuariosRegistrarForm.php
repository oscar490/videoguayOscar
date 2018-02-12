<?php

namespace app\models;

use yii\base\Model;

class UsuariosRegistrarForm extends Model
{
    public $nombre;
    public $clave1;
    public $clave2;
    public $correo;

    public function rules()
    {
        return [
            [['nombre', 'clave1', 'clave2', 'correo'], 'required'],
            [['correo'], 'email'],
            [['nombre'], 'comprobarUsuario'],
            [['clave2'], 'comprobarClave'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'clave1' => 'Clave',
            'clave2'=>'Clave anteior',
        ];
    }

    public function comprobarUsuario($attribute, $params, $validator)
    {
        $usuario = Usuarios::find()->where(['nombre'=>$this->nombre])
            ->one();

        if ($usuario !== null) {
            $this->addError($attribute, 'Ya existe un usuario con ese nombre');
        }
    }

    public function comprobarClave($attribute, $params, $validator)
    {
        if ($this->clave1 !== $this->clave2) {
            $this->addError($attribute, 'Las constraseñas no coinciden');
        }
    }
}
