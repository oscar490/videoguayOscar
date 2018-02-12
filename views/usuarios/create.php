<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;


$this->title = 'Registrar usuario';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'nombre') ?>
    <?= $form->field($model, 'correo') ?>
    <?= $form->field($model, 'clave1')->passwordInput() ?>
    <?= $form->field($model, 'clave2')->passwordInput() ?>

    <?= Html::submitButton('Registrarse', ['class'=>'btn btn-primary']) ?>

<?php ActiveForm::end()?>
