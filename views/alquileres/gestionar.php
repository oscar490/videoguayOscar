<?php
use yii\grid;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

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

        <h3>Alquileres pendientes</h3>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'=> [
                'pelicula.codigo',
                'pelicula.titulo',
                'create_at',
                'devolucion',
            ]
        ])?>
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
