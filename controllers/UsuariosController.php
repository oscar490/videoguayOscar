<?php

namespace app\controllers;

use Yii;

use app\models\UsuariosRegistrarForm;

class UsuariosController extends \yii\web\Controller
{

    public function actionCreate()
    {
        $model = new UsuariosRegistrarForm();

        $model->load(Yii::$app->request->post());
        $model->validate();

        return $this->render('create', [
            'model'=>$model,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
