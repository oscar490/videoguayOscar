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
    <?php if (!empty($alquileres)): ?>
        <table class='table'>
            <thead>
                <th>Código</th>
                <th>Título</th>
                <th>Fecha de alquiler</th>
                <th>Acción</th>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $alquiler): ?>
                    <tr>
                        <td><?= $alquiler->pelicula->codigo ?></td>
                        <td><?= $alquiler->pelicula->titulo ?></td>
                        <td><?= $alquiler->create_at ?></td>
                        <td>
                            <?= Html::beginForm(['alquileres/devolver', 'numero'=>$model->numero]) ?>
                                <?= Html::hiddenInput('id', $alquiler->id) ?>
                                <?= Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger']) ?>
                            <?= Html::endForm() ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <h4>No tiene alquileres realizados</h4>
    <?php endif ?>



</div>
