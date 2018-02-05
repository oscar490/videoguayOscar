<?php
use yii\data\ActiveDataProvider;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var $this \yii\web\View */
/** @var $dataProvider ActiveDataProvider */
 $this->title = 'Listado de películas'
 ?>
<h1><?= $this->title ?></h1>



<?= GridView::widget([
    'dataProvider'=>$dataProvider,
    'columns'=> [
        [
            'class'=>SerialColumn::className(),
            'header'=>'Número',
        ],
        'codigo',
        'titulo',
        [
            // 'class'=>DataColumn::className(), Por defecto.
            'attribute'=>'todo',
            'value'=>function($model, $key, $index, $column) {
                    return $model->codigo . " " . $model->titulo . " "
                        .  Yii::$app->formatter->asCurrency($model->precio_alq);
            },
            'format'=>'text',
        ],
        [
            'class'=>ActionColumn::className(),
            'header'=>'Acciones',
            'template'=>'{delete} {update}',
            'buttons'=> [
                'delete'=> function ($url, $model, $key) {
                    return Html::a(
                        'Borrar',
                        [
                            'peliculas/delete',
                            'id'=>$model->id,
                        ],
                        [
                            'data-confirm'=>'¿Seguro?',
                            'data-method'=>'post',
                            'class'=>'btn-xs btn-danger'
                        ]
                    );
                }
            ]
        ],

    ]
]) ?>
