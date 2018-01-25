<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var $this \yii\web\View */
/** @var $model \app\models\GestionarForm */

?>
<div class='row'>
    <div class='col-md-6'>
        <?php $form = ActiveForm::begin([
                'method'=>'get',
                'action'=>['alquileres/gestionar']
            ]) ?>

            <?= $form->field($model, 'numero') ?>

            <div class='form-group'>
                <?= Html::submitButton('Buscar', ['class'=>'btn btn-success']) ?>
            </div>

        <?php $form = ActiveForm::end() ?>
    </div>
    <div class='col-md-6'>
        <?php if (isset($socio)): ?>
            <?php $pendientes = $socio->getPendientes()
                ->with('pelicula')?>
            <?php if ($pendientes->exists()): ?>
                <h3>Alquileres pendientes</h3>
                <table class='table'>
                    <thead>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Fecha de alquiler</th>
                    </thead>
                    <tbody>
                        <?php foreach ($pendientes->each() as $alquiler): ?>
                        <tr>
                            <td><?= Html::encode($alquiler->pelicula->codigo) ?></td>
                            <td><?= Html::encode($alquiler->pelicula->titulo) ?></td>
                            <td><?= Html::encode(
                                Yii::$app->formatter->asDatetime($alquiler->create_at)
                                ) ?>

                            </td>

                            <?= Html::beginForm(['alquileres/devolver', 'numero'=> $socio->numero], 'post') ?>
                                <td>
                                    <?= Html::submitButton('Devolver', ['class'=>'btin-xs btn-warning'])?>
                                    <?= Html::hiddenInput('id', $alquiler->id) ?>
                                </td>
                            <?= Html::endForm() ?>

                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h3>No tiene películas pendientes</h3>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
