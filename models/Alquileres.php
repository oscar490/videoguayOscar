<?php

namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "alquileres".
 *
 * @property int $id
 * @property int $socio_id
 * @property int $pelicula_id
 * @property string $create_at
 * @property string $devolucion
 *
 * @property Peliculas $pelicula
 * @property Socios $socio
 */
class Alquileres extends \yii\db\ActiveRecord
{
    /**
     * Escenario usado cuando se crea una nueva instancia.
     * @var [type]
     */
    public const ESCENARIO_CREAR = 'crear';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alquileres';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socio_id', 'pelicula_id'], 'required'],
            [['socio_id', 'pelicula_id'], 'default', 'value' => null],
            [['socio_id', 'pelicula_id'], 'integer'],

            [['devolucion'], 'safe'],
            [['socio_id', 'pelicula_id', 'create_at'], 'unique', 'targetAttribute' => ['socio_id', 'pelicula_id', 'create_at']],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socios::className(), 'targetAttribute' => ['socio_id' => 'id']],
            [['pelicula_id'], function ($attribute, $params, $validator) {
                if (Peliculas::findOne(['codigo' => $this->pelicula_id])->estaAlquilada) {
                    $this->addError($attribute, 'La película ya está alquilada.');
                }
            }, 'on' => self::ESCENARIO_CREAR],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'socio_id' => 'Identificadir del Socio',
            'pelicula_id' => 'Identificador de Pelícila',
            'create_at' => 'Fecha de alquiler',
            'devolucion' => 'Devolución',
        ];
    }

    public function getFechaEnlace()
    {
        return Html::a($this->create_at, [
            'alquileres/index',
            'AlquileresSearch[create_at]' => $this->create_at,
        ]);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelicula()
    {
        return $this->hasOne(Peliculas::className(), ['id' => 'pelicula_id'])->inverseOf('alquileres');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Socios::className(), ['id' => 'socio_id'])->inverseOf('alquileres');
    }
}
