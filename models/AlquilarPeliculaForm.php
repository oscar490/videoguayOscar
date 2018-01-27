<?php

namespace app\models;

use yii\base\Model;

class AlquilarPeliculaForm extends Model
{
    public $numero;
    public $codigo;

    public function rules()
    {
        return [
            [['numero', 'codigo'], 'required'],
            [['numero', 'codigo'], 'integer'],
            [
                ['numero'],
                'exist',
                'targetClass' => Socios::className(),
                'targetAttribute' => ['numero' => 'numero'],
            ],
            [
                ['codigo'],
                'exist',
                'targetClass' => Peliculas::className(),
                'targetAttribute' => ['codigo' => 'codigo'],
            ],
            [['codigo'], function ($attribute, $params, $validator) {
                if (Peliculas::findOne(['codigo' => $this->codigo])->estaAlquilada) {
                    $this->addError($attribute, 'La película está alquilada.');
                }
            }],
        ];
    }
}
