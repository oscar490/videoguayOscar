<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class AlquileresPendientesSearch extends Alquileres
{
    public function rules()
    {
        return [
            [['pelicula.codigo'], 'integer'],
            [['pelicula.titulo', 'create_at'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'pelicula.codigo',
            'pelicula.titulo',
        ]);
    }

    public function search($params, $numero)
    {
        $query = Socios::findOne(['numero' => $numero])
            ->getAlquileres()
            ->joinWith('pelicula')
            ->where(['devolucion' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        $dataProvider->sort->attributes['pelicula.titulo'] = [
            'asc' => ['peliculas.titulo' => SORT_ASC],
            'desc' => ['peliculas.titulo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['pelicula.codigo'] = [
            'asc' => ['peliculas.codigo' => SORT_ASC],
            'desc' => ['peliculas.codigo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'peliculas.codigo' => $this->getAttribute('pelicula.codigo'),
            'cast(create_at as date)' => $this->create_at,
        ]);

        $query->andFilterWhere([
            'like',
            'lower(peliculas.titulo)',
            mb_strtolower($this->getAttribute('pelicula.titulo')),
        ]);

        return $dataProvider;
    }
}
