<?php

namespace app\models;

use yii\base\Model;
use app\models\Socios;

class GestionarSociosForm extends Model
{
    public $numero;
    public $nombre;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['numero'], 'required' ],

            [['numero'], 'default'],
            [['numero'], 'filter', 'filter' =>function ($value) {
                if (!ctype_digit($value)) {
                    $socio = Socios::find()
                    ->where([
                    'like',
                    'lower(nombre)',
                     mb_strtolower($value)
                     ])->one();
                    if ($socio !== null) {
                         $value = $socio->numero;
                    }
                }
                return $value;
            }],
            [['numero'], 'integer', 'enableClientValidation'=>false],
            [
                ['numero'],
                'exist',
                'skipOnError' => true,
                'targetClass'=>Socios::className(),
                'targetAttribute'=>['numero'=>'numero'],
                'message'=>'No existe el socio',
            ],
                
        ];
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de Socio:',
        ];
    }
}
