<?php
use yii\grid;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\datecontrol\DateControl;

$this->title = 'Gestión de Alquileres';
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method'=>'get',
    'action'=>['alquileres/gestionar'],
    'id'=>'gestionar-socios',
    'enableAjaxValidation'=>true,
    ]) ?>

    <?= $form->field($modeloSocios, 'numero', ['enableAjaxValidation'=>true]) ?>

    <div class='form-group'>
        <?= Html::submitButton('Buscar Socio', ['class'=>'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>

<?php if (isset($socio)): ?>

    <h3>Alquileres pendientes de <?= $socio->enlace ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns'=> [
            'pelicula.codigo',
            [
                'attribute'=>'pelicula.titulo',
                'value'=> function ($model) {
                    return $model->pelicula->enlace;
                },
                'format'=>'raw',
            ],
            [
                'attribute'=> 'create_at',
                'filter' => DateControl::widget([
                    'type'=>DateControl::FORMAT_DATE,
                    'model'=>$searchModel,
                    'attribute' => 'create_at',
                ]),
                'content'=> function ($model, $key, $index, $column) {
                    return Html::a($model->create_at, [
                        'alquileres/gestionar',
                        'numero'=>$model->socio->numero,
                        'AlquileresSearch[create_at]'=>$model->create_at,
                    ]);
                },
                'format'=>'datetime',
            ],
            [
                'class'=>'yii\grid\ActionColumn',
                'header'=>'Acciones',
                'template'=>"{devolver}",
                'buttons'=>[
                    'devolver' => function ($url, $model, $param) {
                        return $model->getFormularioDevolver($model->id, $model->socio->numero);

                    }
                ]
            ]
        ]
    ])?>

    <hr>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],

        ]) ?>

        <?= $form->field($modeloPeliculas, 'codigo') ?>
        <?= Html::hiddenInput('numero', $modeloSocios->numero) ?>
        <div class='form-group'>
            <?= Html::submitButton('Buscar película', ['class'=>'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>


        <?php if (isset($pelicula)): ?>

            <?php $alquiler = $pelicula->getAlquileres()
                ->where(['devolucion'=>null])
                ->one();
            ?>

            <h4><?= $pelicula->enlace ?></h4>
            <h4><?= Yii::$app->formatter->asCurrency($pelicula->precio_alq)?></h4>
            <?php if ($pelicula->estaAlquilada): ?>
                <h4>está alquilada por
                    <?= $alquiler->socio->enlace; ?>
                </h4>

                <?= $alquiler->getFormularioDevolver(
                        $alquiler->id,
                        $alquiler->socio->numero
                    ); ?>

            <?php else: ?>

                <?= $pelicula->getAlquileres()->one()
                    ->getFormularioAlquilar($socio->id, $pelicula->id);
                ?>
            <?php endif ?>
        <?php endif ?>
<?php endif ?>
