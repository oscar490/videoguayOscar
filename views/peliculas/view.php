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
            'id',
            'codigo',
            'titulo',
            'precio_alq',
        ],
    ]) ?>

    <?php if (!empty($alquileres)):  ?>
        <h3>Últimos alquileres de esta película</h3>
        <table class='table'>
            <thead>
                <th>Número</th>
                <th>Nombre</th>
                <th>Fecha de alquiler</th>
                <th>Fecha de devolución</th>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $alquiler): ?>
                    <tr>
                        <td><?= Html::encode($alquiler->socio->numero)?></td>
                        <td>
                            <?= Html::a(
                                $alquiler->socio->nombre,
                                ['socios/view','id'=>$alquiler->socio->id]
                            );
                            ?>
                        </td>
                        <td><?= Yii::$app->formatter->asDatetime($alquiler->create_at)?></td>
                        <td>
                            <?php if ($alquiler->devolucion === null): ?>
                                <?= Html::beginForm([
                                    'alquileres/devolver',
                                    'numero'=>$alquiler->socio->numero,
                                    ])
                                ?>
                                    <?= Html::hiddenInput('id', $alquiler->id) ?>
                                    <?= Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger']) ?>
                                <?= Html::endForm() ?>
                            <?php else: ?>
                                <?= Yii::$app->formatter->asDatetime($alquiler->devolucion)?>
                            <?php endif ?>


                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <h3>No se han realizado alquileres de esta película</h3>
    <?php endif ?>

</div>
