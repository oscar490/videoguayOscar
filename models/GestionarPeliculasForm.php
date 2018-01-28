<?php

namespace app\models;

use yii\base\Model;

class GestionarPeliculasForm extends Model
{
    public $codigo;

    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'integer'],
            [
                ['codigo'],
                'exist',
                'skipOnError' => true,
                'targetClass'=>Peliculas::className(),
                'targetAttribute'=>['codigo'=>'codigo'],
            ]
        ];
    }

    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
            'codigo' => 'Código de la película',
        ];
    }
}
