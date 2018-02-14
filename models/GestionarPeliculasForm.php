<?php

namespace app\models;

use yii\base\Model;

class GestionarPeliculasForm extends Model
{
    public $codigo;
    public $numero;

    public function rules()
    {
        return [
            [['codigo', 'numero'], 'required'],
            [['codigo'], 'buscarPelicula'],
            [
                ['codigo'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Peliculas::className(),
                'targetAttribute' => ['codigo' => 'codigo'],
            ],
            [
                ['numero'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Socios::className(),
                'targetAttribute' => ['numero' => 'numero'],
            ],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function buscarPelicula($attribute, $params, $validator)
    {
        if (!ctype_digit($this->codigo)) {
            $pelicula = Peliculas::find()
                ->where([
                    'like', 'lower(titulo)', mb_strtolower($this->codigo),
                ])->one();
            if ($pelicula !== null) {
                $this->codigo = $pelicula->codigo;
            } else {
                $this->addError($attribute, 'No existe la película');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'codigo' => 'Código de la película',
        ];
    }
}
