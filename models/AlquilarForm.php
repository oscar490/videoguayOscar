<?php

namespace app\models;

use yii\base\Model;

class AlquilarForm extends Model
{
    /**
     * El número del socio.
     * @var string
     */
    public $numero;

    /**
     * El código de la película.
     * @var string
     */
    public $codigo;

    public function rules()
    {
        return [
                [['numero', 'codigo'], 'required'],
                [['numero', 'codigo'], 'number'],
                [
                    ['numero'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Socios::className(),
                    'targetAttribute' => ['numero' => 'numero'],
                ],
                [
                    ['codigo'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Peliculas::className(),
                    'targetAttribute' => ['numero' => 'numero'],
                ],
        ];
    }
}
