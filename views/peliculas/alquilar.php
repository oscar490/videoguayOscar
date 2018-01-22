
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Alquilar una película';
$this->params['breadcrumbs'][] = ['label' => 'Peliculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'id'=>'alquilar-form',

]);
?>
<?= $form->field($alquilarForm, 'numero') ?>
<?= $form->field($alquilarForm, 'codigo') ?>

<div class="from-group">
    <div >
        <?= Html::submitButton('Alquilar', ['class'=>'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
