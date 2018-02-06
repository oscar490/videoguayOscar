<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\Peliculas */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Peliculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peliculas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            'titulo',
            'precio_alq:currency:Precio',
        ],
    ]) ?>
<h3>Últimos alquileres de esta película</h3>
    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=> [
            'socio.numero',
            'socio.nombre',
            [
                'attribute'=>'create_at',
                'format'=>'dateTime',
                'label'=>'Fecha de alquiler',
            ],

            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{devolver}',
                'header'=>'Acciones',
                'buttons'=> [
                    'devolver'=> function ($url, $model, $params) {
                        return $model->create_at;
                    }
                ]
            ]

        ]
    ]) ?>







</div>
