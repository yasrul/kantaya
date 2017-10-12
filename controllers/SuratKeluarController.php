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
 * Description of SuratKeluarController
 *
 * @author yasrul
 */

class SuratKeluarController extends Controller {
    
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'out');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndexDispo() {
        
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
        $modelTujuan = [new TujuanSurat];
     
        if ($modelSurat->load(Yii::$app->request->post())) {
            $modelSurat->id_pengirim = Yii::$app->user->identity->unit_id;
            
            $modelTujuan = Model::createMultiple(TujuanSurat::className());
            Model::loadMultiple($modelTujuan, Yii::$app->request->post());
            //assign default id_surat
            foreach ($modelTujuan as $tujuan) {
                $tujuan->id_surat = 0;
            }
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelTujuan),
                    ActiveForm::validate($modelSurat)
                );
            }
            // validate all models
            $valid1 = $modelSurat->validate();
            $valid2 = Model::validateMultiple($modelTujuan);
            $valid = $valid1 && $valid2;
            
            if ($valid) {
                // mulai database transaction
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // simpan master record                   
                    if ($flag = $modelSurat->save(false)) {
                        // simpan details record
                        foreach ($modelTujuan as $tujuan) {
                            $tujuan->id_surat = $modelSurat->id;
                            if (! ($flag = $tujuan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        // sukses, commit database transaction
                        // kemudian tampilkan hasilnya
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelSurat->id]);
                    } else {
                        return $this->render('create', [
                            'modelSurat' => $modelSurat,
                            'modelTujuan' => $modelTujuan,
                        ]);
                    }
                } catch (Exception $ex) {
                    // penyimpanan gagal, rollback database transaction
                    $transaction->rollBack();
                    throw $ex;
                }
            } else {
                return $this->render('create', [
                    'modelSurat' => $modelSurat,
                    'modelTujuan' => $modelTujuan,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }
           
        } else {
            // inisialisai id 
            // diperlukan untuk form master-detail
            $modelSurat->id = 0;
            // render view
            return $this->render('create', [
                'modelSurat' => $modelSurat,
                'modelTujuan' => $modelTujuan,
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
