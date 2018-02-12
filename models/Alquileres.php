<?php

namespace app\models;

use Yii;

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
        $fecha = Yii::$app->formatter->asDatetime(($this->create_at));
        return Html::a($fecha, [
            'alquileres/index',
            'AlquileresSearch[create_at]' => $this->create_at,
        ]);
    }

    public function getFormularioDevolver($id, $numero)
    {
        return Html::beginForm(['alquileres/devolver', 'numero' => $numero])
            . Html::hiddenInput('id', $id)
            . Html::submitButton('Devolver', ['class' => 'btn-xs btn-danger'])
            . Html::endForm();
    }

    public function getFormularioAlquilar($socio_id, $pelicula_id)
    {
        return Html::beginForm(['alquileres/alquilar'])
            . Html::hiddenInput('pelicula_id', $pelicula_id)
            . Html::hiddenInput('socio_id', $socio_id)
            . Html::submitButton('Alquilar', ['class' => 'btn btn-primary'])
            . Html::endForm();
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
