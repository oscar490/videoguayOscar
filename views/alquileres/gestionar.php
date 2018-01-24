<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var $this \yii\web\View */
/** @var $model \app\models\GestionarForm */

?>
<div class='row'>
    <div class='col-md-6'>
        <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'numero') ?>

            <div class='form-group'>
                <?= Html::submitButton('Buscar', ['class'=>'btn btn-success']) ?>
            </div>

        <?php $form = ActiveForm::end() ?>
    </div>
    <div class='col-md-6'>
        <?php if (isset($socio)): ?>
            <h3><?= Html::encode($socio->nombre)?></h3>
            <h3><?= Html::encode($socio->telefono)?></h3>
            <?php foreach ($socio->pendientes as $alquiler): ?>
                
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
