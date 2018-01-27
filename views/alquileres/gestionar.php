<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
var_dump($modelo);
?>

<?php $form = ActiveForm::begin([
    'method'=>'get',
    'action'=>['alquileres/gestionar'],
    ]) ?>

    <?= $form->field($modelo, 'numero') ?>

    <div class='form-group'>
        <?= Html::submitButton('Buscar', ['class'=>'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>
