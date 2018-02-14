<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;


$this->title = 'Gestión de Alquileres';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id'=>'gestionar-peliculas-form',
    'method'=>'get',
    'action'=>['alquileres/gestionar-ajax'],
]) ?>
    <?= $form->field(
        $gestionarPeliculasForm,
        'codigo',
        ['enableAjaxValidation'=>true]
    ) ?>
    <?= $form->field(
        $gestionarPeliculasForm,
        'numero',
        ['enableAjaxValidation'=>true]
    ) ?>
<?php ActiveForm::end() ?>

<?php $form = ActiveForm::begin([
        'id'=>'alquilar-ajax',
        'action'=>['alquileres/alquilar-ajax'],
    ]) ?>
    <div style="display: none">
        <?= Html::submitButton('Alquilar', ['class'=>'btn btn-success']) ?>
    </div>

    <div class='col-md-6'>
        <div id='pendientes'>

        </div>
    </div>



<?php ActiveForm::end() ?>
    <div id='socio'>
    </div>

    <div id='pelicula'>
    </div>
