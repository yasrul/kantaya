<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Model;
use app\models\Surat;
use app\models\search\SuratSearch;
use app\models\Register;
use app\models\search\RegisterSearch;
use app\models\TujuanSurat;

/**
 * Description of SuratMasukController
 *
 * @author yasrul
 */
class SuratMasukController extends Controller 
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete'],
                        'allow' => TRUE,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }
    
    public function actionIndex() {
        $searchModel = new SuratSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'in');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id) {
        return $this->render('view', [
            'modelSurat' => $this->findModel($id),
        ]);
    }

        /**
     * Creates a new Surat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelSurat = new Surat();
        if ($modelSurat->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelSurat->tujuan = Yii::$app->request->post('TujuanSurat', []);
                if ($modelSurat->save()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelSurat->id]);
                }
                $transaction->rollBack();
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        } else {
            return $this->render('create', [
                'modelSurat' => $modelSurat,
            ]);
        }      
    }
    
    public function actionUpdate($id) {
        $modelSurat = $this->findModel($id);
        
        if ($modelSurat->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelSurat->tujuan = Yii::$app->request->post('TujuanSurat', []);
                if ($modelSurat->save()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelSurat->id]);
                }
                $transaction->rollBack();
                
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        } else {
            return $this->render('update', [
                'modelSurat' => $modelSurat
            ]);
        }
    }
    
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

        protected function findModel($id) {
        if (($model = Surat::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException ('The requested page does not exist.');
        }
    }
}
