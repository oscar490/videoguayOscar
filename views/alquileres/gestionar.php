<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Gestión de Alquileres';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->get('mensaje') !== null): ?>
    <div class='alert alert-success'>
        <?= Yii::$app->session->get('mensaje') ?>
        <?php Yii::$app->session->remove('mensaje') ?>
    </div>
<?php endif ?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'method'=>'get',
    'action'=>['alquileres/gestionar'],
    ]) ?>

    <?= $form->field($modeloSocios, 'numero') ?>

    <div class='form-group'>
        <?= Html::submitButton('Buscar Socio', ['class'=>'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>

<?php if (isset($socio)): ?>

    <h3><?= $socio->enlace ?></h3>
    <?php if (!empty($alquileres)): ?>
        <h3>Alquileres pendientes</h3>
        <table class='table'>
            <thead>
                <td>Código</td>
                <td>Título</td>
                <td>Fecha de alquiler</td>
                <td>Acciones</td>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $alquiler): ?>
                    <tr>
                        <td><?= Html::encode($alquiler->pelicula->codigo) ?></td>
                        <td><?= Html::a($alquiler->pelicula->titulo, ['peliculas/view', 'id'=>$alquiler->pelicula->id]) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($alquiler->create_at) ?></td>
                        <td>
                            <?= Html::beginForm(['alquileres/devolver','post', 'numero'=>$socio->numero]) ?>
                                    <?= Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger']) ?>
                                    <?= Html::hiddenInput('id', $alquiler->id) ?>
                            <?= Html::endForm() ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <h3>No tiene alquileres pendientes</h3>
    <?php endif ?>

    <hr>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar']
        ]) ?>

        <?= $form->field($modeloPeliculas, 'codigo') ?>
        <?= Html::hiddenInput('numero', $modeloSocios->numero) ?>
        <div class='form-group'>
            <?= Html::submitButton('Buscar película', ['class'=>'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>

        <?php if (isset($pelicula)): ?>

            <h4><?= Html::a($pelicula->titulo, ['peliculas/view', 'id'=>$pelicula->id]) ?></h4>
            <h4><?= Yii::$app->formatter->asCurrency($pelicula->precio_alq) ?></h4>
            <?php if ($pelicula->estaAlquilada): ?>
                <h4>está alquilada por
                    <?php $alquiler = $pelicula->getAlquileres()
                        ->where(['devolucion'=>null])
                        ->one();
                    ?>
                    <?=
                        $alquiler->socio->enlace;
                    ?>
                </h4>

                <?= Html::beginForm(['alquileres/devolver', 'numero'=>$alquiler->socio->numero]) ?>
                    <?= Html::hiddenInput('id', $alquiler->id) ?>
                    <?= Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger']) ?>
                <?= Html::endForm() ?>
            <?php else: ?>
                <?= Html::beginForm([
                    'alquileres/alquilar',
                ]) ?>
                    <?= Html::hiddenInput('pelicula_id', $pelicula->id) ?>
                    <?= Html::hiddenInput('socio_id', $socio->id) ?>
                    <?= Html::submitButton('Alquilar', ['class'=>'btn btn-primary']) ?>
                <?= Html::endForm() ?>
            <?php endif ?>
        <?php endif ?>





<?php endif?>
