<?php
use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;


$this->title = 'Gestión de Alquileres';
$this->params['breadcrumbs'][] = $this->title;
$urlDatosAjax = Url::to(['socios/datos-ajax']);
$js = <<<EOT
    var form = $('#gestionar-peliculas-form');
    form.on('afterValidateAttribute', function (event, attribute, messages) {
        switch(attribute.name) {
            case 'numero':
                if (messages.length === 0) {
                    $.ajax({
                        url: '$urlDatosAjax',
                        type: 'GET',
                        data: {
                            numero: form.yiiActiveForm('find', 'numero').value
                        },
                        success: function (data) {
                            $('#socio').html(data);
                        }
                    });
                } else {
                    $('#socio').empty();
                }
                break;

            case 'codigo':
                //..
                break;
        }
    })
EOT;
$this->registerJS($js);
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
