<?php

namespace app\controllers;

use app\models\Alquileres;
use app\models\AlquileresSearch;
use app\models\GestionarPeliculasForm;
use app\models\GestionarSociosForm;
use app\models\Peliculas;
use app\models\Socios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/**
 * AlquileresController implements the CRUD actions for Alquileres model.
 */
class AlquileresController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['gestionar', 'index', 'alquilar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['gestionar'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'alquilar'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->nombre === 'pepe';
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionPendientes($numero)
    {
        $socio = Socios::findOne(['numero'=>$numero]);

        if ($socio === null) {
            return '';
        }

        $pendientes = $socio->getPendientes()->with('pelicula');

        return $this->renderAjax('pendientes', [
            'pendientes'=>$pendientes,
        ]);
    }

    /**
     * Alquila y devuelve películas en una sola acción.
     * @return mixed
     * @param null|mixed $numero
     * @param null|mixed $codigo
     */
    public function actionGestionar($numero = null, $codigo = null)
    {
        $modeloSocios = new GestionarSociosForm([
            'numero' => $numero,
        ]);

        $modeloPeliculas = new GestionarPeliculasForm([
            'codigo' => $codigo,
        ]);

        $searchModel = new AlquileresSearch();

        $data = [];

        if ($numero !== null && $modeloSocios->validate()) {
            $data['socio'] = Socios::findOne(['numero' => $modeloSocios->numero]);

            $data['dataProvider'] = $searchModel->search(Yii::$app->request->get(), $modeloSocios->numero);

            $data['dataProvider']->query
                ->andWhere([
                    'numero' => $modeloSocios->numero,
                    'devolucion' => null,
                ]);

            $data['searchModel'] = $searchModel;

            if ($codigo != null && $modeloPeliculas->validate()) {
                $data['pelicula'] = Peliculas::findOne([
                    'codigo' => $modeloPeliculas->codigo,
                ]);
            }
        }

        Yii::$app->session->set(
            'rutaVuelta',
            Url::to(['alquileres/gestionar', 'numero' => $numero])
        );

        $data['modeloSocios'] = $modeloSocios;
        $data['modeloPeliculas'] = $modeloPeliculas;

        return $this->render('gestionar', $data);
    }

    public function actionGestionarAjax($numero = null, $codigo = null)
    {
        $gestionarPeliculasForm = new GestionarPeliculasForm([
            'codigo'=>$codigo,
            'numero'=>$numero,
        ]);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return  ActiveForm::validate($gestionarPeliculasForm);
        }

        return $this->render('gestionar-ajax', [
            'gestionarPeliculasForm'=>$gestionarPeliculasForm
        ]);
    }
    /**
     * Devuelve un alquiler indicado por el id pasado por post.
     * @param  string $numero        Número del socio para volver a él.
     * @return Response              La redirección.
     * @throws NotFoundHttpException Si el id falta o no es correcto.
     */
    public function actionDevolver($numero)
    {
        $id = Yii::$app->request->post('id');

        $alquiler = Alquileres::findOne($id);
        $alquiler->devolucion = date('Y-m-d H:i:s');
        $alquiler->save();

        $url = Yii::$app->session->get(
            'rutaVuelta',
            ['alquileres/gestionar', 'numero' => $numero]
        );
        Yii::$app->session->set('mensaje', 'Se ha realizado la devolución correctamente');
        Yii::$app->session->remove('rutaVuelta');
        return $this->redirect($url);
    }


    /**
     * Lists all Alquileres models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlquileresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = [
            'pageSize' => '5',
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionListado()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Alquileres::find()
                ->joinWith(['socio', 'pelicula']),
        ]);

        $dataProvider->sort->attributes['socio.numero'] = [
            'asc' => ['socios.numero' => SORT_ASC],
            'desc' => ['socios.numero' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['pelicula.codigo'] = [
            'asc' => ['peliculas.codigo' => SORT_ASC],
            'desc' => ['peliculas.codigo' => SORT_DESC],
        ];


        return $this->render('listado', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alquileres model.
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
     * Alquila una película dados 'socio_id' y 'pelicula_id
     * pasados por POST.
     * @return Response LA redirección
     * @throws NotFoundHttpException [description]
     */
    public function actionAlquilar()
    {
        $socio_id = Yii::$app->request->post('socio_id');
        $pelicula_id = Yii::$app->request->post('pelicula_id');
        $alquiler = new Alquileres([
            'socio_id' => $socio_id,
            'pelicula_id' => $pelicula_id,
        ]);
        Yii::$app->session->set('mensaje', 'Se ha realizado el alquiler correctamente');
        $alquiler->save();

        $url = Yii::$app->session->get(
            'rutaVuelta',
            ['alquileres/gestionar', 'numero' => $alquiler->socio->numero]
        );

        Yii::$app->session->remove('rutaVuelta');

        $this->redirect($url);
    }

    /**
     * Creates a new Alquileres model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alquileres();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Alquileres model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Alquileres model.
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
     * Finds the Alquileres model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Alquileres the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alquileres::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
