<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'acces' => [
                'class' => AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Usuarios::find(),
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::ESCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->set('mensaje', 'Se ha enviado un correo electrónico a la dirección indicada');

                Yii::$app->mailer->compose()
                    ->setFrom('dwesoscar@gmail.com')
                    ->setTo($model->email)
                    ->setSubject('Registro de usuario')
                    ->setHtmlBody(Url::to("usuarios/validar?token=$model->token_val", true))
                    ->send();
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionValidar($token = null)
    {
        $usuario = Usuarios::findOne(['token_val' => $token]);

        if ($usuario !== null) {
            $usuario->token_val = null;
            $usuario->save();

            Yii::$app->session->set('mensaje', 'Ya tiene la cuenta correctamente activada.');
            $this->redirect(['site/login']);
        }
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = Usuarios::ESCENARIO_UPDATE;
        $model->password = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goHome();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
