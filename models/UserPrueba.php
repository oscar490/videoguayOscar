<?php

namespace app\models;

use yii\base\Model;

class UserPrueba extends Model
{
    public $name;
    public $email;
    public $body;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public function attributeLabels()
    {
        return [
            'name' => 'Tu nombre',
            'email' => 'Tu dirección de Correo',
            'body' => 'Contenido',
        ];
    }

    public function rules()
    {
        return [
            [
                ['name', 'email'],
                'required',
                'on' =>self::SCENARIO_REGISTER,
            ],
            [
                ['name'],
                'string',
                'on' => self::SCENARIO_LOGIN,
            ],
            [['email'], 'email'],
        ];
    }
}
