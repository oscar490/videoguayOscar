<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Socios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ]]);?>
         <?= Html::a('Gestionar', ['alquileres/gestionar','numero'=>$model->numero], [
                'class'=>'btn btn-success',
            ])
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'numero',
            'nombre',
            'direccion',
            'telefono',
        ],
    ]) ?>


    <h3>Últimos alquileres</h3>
    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=> [
            'pelicula.codigo',
            'pelicula.titulo',
            'create_at',
            [
                'class'=>'yii\grid\ActionColumn',
                'header'=>'Acciones',
                'template'=>"{devolver}",
                'buttons'=> [
                    'devolver'=> function ($url, $model, $key) {
                        if ($model->devolucion === null) {

                            return $model->getFormularioDevolver(
                                $model->id,
                                $model->socio->numero
                            );

                        } else {
                            return $model->devolucion;
                        }
                    }
                ]
            ]
        ]
    ]) ?>



</div>
