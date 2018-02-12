<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AlquileresSearch represents the model behind the search form of `app\models\Alquileres`.
 */
class AlquileresSearch extends Alquileres
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'socio_id', 'pelicula_id', 'socio.numero', 'pelicula.codigo'], 'integer'],
            [
                [
                    'create_at',
                    'devolucion',
                    'pelicula.titulo',
                    'socio.numero',
                    'socio.nombre',
                    'pelicula.codigo',
                ],
                'safe',
            ],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'pelicula.titulo',
            'socio.numero',
            'socio.nombre',
            'pelicula.codigo',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Alquileres::find()->joinWith(['pelicula', 'socio']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $dataProvider->sort->attributes['pelicula.titulo'] = [
            'asc' => ['peliculas.titulo' => SORT_ASC],
            'desc' => ['peliculas.titulo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['socio.numero'] = [
            'asc' => ['socios.numero' => SORT_ASC],
            'desc' => ['socios.numero' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['socio.nombre'] = [
            'asc' => ['socios.nombre' => SORT_ASC],
            'desc' => ['socios.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['pelicula.codigo'] = [
            'asc' => ['peliculas.codigo' => SORT_ASC],
            'desc' => ['peliculas.codigo' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['create_at' => SORT_DESC];



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'devolucion' => $this->devolucion,
            'socio_id' => $this->socio_id,
            'socios.numero' => $this->getAttribute('socio.numero'),
            'peliculas.codigo' => $this->getAttribute('pelicula.codigo'),
            'cast(create_at as date)' => $this->create_at,
        ]);

        $query->andFilterWhere([
            'like',
            'lower(peliculas.titulo)',
            mb_strtolower($this->getAttribute('pelicula.titulo')),
        ]);

        $query->andFilterWhere([
            'like',
            'lower(socios.nombre)',
            mb_strtolower($this->getAttribute('socio.nombre')),
        ]);






        return $dataProvider;
    }
}
