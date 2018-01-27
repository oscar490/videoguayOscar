<?php

namespace app\models;

use yii\base\Model;

class GestionarForm extends Model
{
    public $numero;

    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de Socio:',
        ];
    }
}
