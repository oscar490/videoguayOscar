<?php

namespace app\controllers;

use app\models\AlquilarPeliculaForm;
use app\models\Alquileres;
use app\models\Peliculas;
use app\models\PeliculasSearch;
use app\models\Socios;
use Yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Sort;

/**
 * PeliculasController implements the CRUD actions for Peliculas model.
 */
class PeliculasController extends Controller
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
        ];
    }

    /**
     * Muestra un listado paginado de películas
     * @return mixed
     */
    public function actionListado()
    {
        $peliculas = Peliculas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $peliculas,
            'pagination' => [
                'totalCount'=>$peliculas->count(),
                'pageSize' => 2, // 20 por defecto
            ],
            'sort' => [
                'attributes'=> [
                    'codigo'=>['label'=>'Código'],
                    'titulo'=>['label'=>'Título', 'default'],
                    'precio_alq'=>['label'=>'Precio de alquiler'],
                ]
            ],
        ]);


        return $this->render('listado', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Alquila una pelicula.
     * @return mixed
     */
    public function actionAlquilar()
    {
        $modelo = new AlquilarPeliculaForm();

        if ($modelo->load(Yii::$app->request->post()) && $modelo->validate()) {
            $alquiler = new Alquileres();
            $socio = Socios::findOne(['numero' => $modelo->numero]);
            $pelicula = Peliculas::findOne(['codigo' => $modelo->codigo]);
            $alquiler->socio_id = $socio->id;
            $alquiler->pelicula_id = $pelicula->id;
            $alquiler->save();
            $this->redirect(['peliculas/index']);
        }

        return $this->render('alquilar', [
            'modelo' => $modelo,
        ]);
    }
    /**
     * Lists all Peliculas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeliculasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Peliculas model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $s = Socios::find()
        //     ->joinWith('peliculas p')
        //     ->where(['p.id' => $id])
        //     ->limit(10);

        $alquileres = Alquileres::find()
            ->with('socio') //  Nombre de relacion.
            ->where(['pelicula_id' => $id])
            ->orderBy(['create_at' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'alquileres' => $alquileres,
        ]);
    }

    /**
     * Creates a new Peliculas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Peliculas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Peliculas model.
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
     * Deletes an existing Peliculas model.
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
     * Finds the Peliculas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Peliculas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Peliculas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
