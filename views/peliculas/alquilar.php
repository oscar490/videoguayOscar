<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Alquilar una película';
$this->params['breadcrumbs'][] = ['label' => 'Peliculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($modelo, 'numero') ?>
    <?= $form->field($modelo, 'codigo') ?>

    <div class='form-group'>
        <?= Html::submitButton('Alquilar', ['class'=>'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end(); ?>
