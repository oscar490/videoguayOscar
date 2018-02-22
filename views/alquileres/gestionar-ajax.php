<?php

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;

$this->title = 'Gestión de Alquileres por Ajax  ';
$this->params['breadcrumbs'][] = $this->title;

$urlSociosDatos = Url::to(['socios/datos-ajax']);
$urlPeliculasDatos = Url::to(['peliculas/datos-ajax']);
$urlAlquileresDatos = Url::to(['alquileres/pendientes']);
$js = <<<EOT
    var form = $('#gestionar-peliculas');
    form.on('afterValidateAttribute', function (event, attribute, messages) {
        switch (attribute.name) {
            case 'numero':
                if (messages.length === 0) {
                    $.ajax({
                        url: '$urlSociosDatos',
                        type: 'GET',
                        data: {
                            numero: form.yiiActiveForm('find', 'numero').value
                        },
                        success: function (data) {
                            $('#socio').html(data);
                        }
                    });
                    $.ajax({
                        url: '$urlAlquileresDatos',
                        type: 'GET',
                        data: {
                            numero: form.yiiActiveForm('find', 'numero').value
                        },
                        success: function (data) {
                            $('#alquileres').html(data);
                            
                        }
                    });
                } else {
                    $('#socio').empty();
                    $('#alquileres').empty();
                }
                break;

            case 'codigo':
                if (messages.length === 0) {
                    $.ajax({
                        url: '$urlPeliculasDatos',
                        type: 'GET',
                        data: {
                            codigo: form.yiiActiveForm('find', 'codigo').value
                        },
                        success: function (data) {
                            $('#pelicula').html(data);
                        }
                    })
                } else {
                    $('#pelicula').empty();
                }
                break;
        }
    })
EOT;
$this->registerJs($js);
 ?>

 <?php $form = ActiveForm::begin([
        'id'=>'gestionar-peliculas',
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
    <div id='alquileres'>
    </div>
    <?= $form->field(
        $gestionarPeliculasForm,
        'codigo',
        ['enableAjaxValidation'=>true]
    ) ?>
    <div id='pelicula'>
    </div>

 <?php ActiveForm::end() ?>
