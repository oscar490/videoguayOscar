<?php

namespace app\models;

use yii\base\Model;

class GestionarSociosForm extends Model
{
    public $numero;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['numero'], 'required' ],
            [['numero'], 'integer'],
            [['numero'], 'default'],
            [
                ['numero'],
                'exist',
                'skipOnError' => true,
                'targetClass'=>Socios::className(),
                'targetAttribute'=>['numero'=>'numero'],
                'message'=>'No existe el socio',
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de Socio:',
        ];
    }
}
