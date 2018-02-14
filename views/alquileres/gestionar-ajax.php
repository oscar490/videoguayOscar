<?php

use yii\helpers\Html;
use yii\helpers;
use yii\helpers\Url;


use yii\widgets\ActiveForm;

$js = <<<EOT
function isEmpty(el) {
    return !$.trim(el.html());
}

function botonAlquilar() {
    if (!isEmpty($('#socio')) && !isEmpty($('pelicula'))) {
        $('#btn-alquilar').show();
    } else {
        $()
    }
}
EOT;
$this->title = 'Gestión de Alquileres';
$this->params['breadcrumbs'][] = $this->title;
$urlDatosAjax = Url::to(['socios/datos-ajax']);
$urlPeliculasAjax = Url::to(['peliculas/datos-ajax']);
$urlAlquileresPendientes = Url::to(['alquileres/pendientes']);
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
                    $.ajax({
                        url: '$urlAlquileresPendientes',
                        type: 'GET',
                        data: {
                            numero: form.yiiActiveForm('find', 'numero').value
                        },
                        success: function (data) {
                            $('#pendientes').html(data);
                        }
                    });
                } else {
                    $('#socio').empty();
                }
                break;

            case 'codigo':
                if (messages.length === 0) {
                    $.ajax({
                        url: '$urlPeliculasAjax',
                        type: 'GET',
                        data: {
                            codigo: form.yiiActiveForm('find', 'codigo').value
                        },
                        success: function (data) {
                            $('#pelicula').html(data);
                        }
                    });
                } else {
                    $('#pelicula').empty();
                }
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
        'numero',
        ['enableAjaxValidation'=>true]
    ) ?>
    <div id='socio'>
    </div>
    <?= $form->field(
        $gestionarPeliculasForm,
        'codigo',
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


    <div id='pelicula'>
    </div>
