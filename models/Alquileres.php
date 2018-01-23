<?php

namespace app\models;

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
            [['create_at', 'devolucion'], 'safe'],
            [['socio_id', 'pelicula_id', 'create_at'], 'unique', 'targetAttribute' => ['socio_id', 'pelicula_id', 'create_at']],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socios::className(), 'targetAttribute' => ['socio_id' => 'id']],
            // [['pelicula_id'], function ($attribute, $params, $validator) {
            //     $this->addError($attribute, 'Horror');
            // }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'socio_id' => 'Socio ID',
            'pelicula_id' => 'Pelicula ID',
            'create_at' => 'Create At',
            'devolucion' => 'Devolucion',
        ];
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
