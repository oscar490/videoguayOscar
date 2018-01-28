<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Gestionar películas';
$this->params['breadcrumbs'][] = $this->title;

?>

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
    <h3>Alquileres pendientes de <?= $socio->nombre ?></h3>

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
                    <td><?= Html::encode($alquiler->pelicula->titulo) ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($alquiler->create_at) ?></td>
                    <td>
                        <?= Html::beginForm(['alquileres/devolver', 'post']) ?>
                                <?= Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger']) ?>

                                <?= Html::hiddenInput('codigo', $alquiler->id) ?>
                        <?= Html::endForm() ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar']
        ]) ?>

        <?= $form->field($modeloPeliculas, 'codigo') ?>
        <?= Html::hiddenInput('numero', $modeloSocios->numero) ?>
        <div class='form-group'>
            <?= Html::submitButton('Buscar película', ['class'=>'btn btn-primary']) ?>
        </div>

        <?php if (isset($pelicula)): ?>

            <h4><?= $pelicula->titulo ?></h4>
            <h4><?= Yii::$app->formatter->asCurrency($pelicula->precio_alq) ?></h4>
            <?php if ($pelicula->estaAlquilada): ?>
                <h4>Está alquilada</h4>
            <?php endif ?>
        <?php endif ?>




    <?php ActiveForm::end() ?>
<?php endif?>
