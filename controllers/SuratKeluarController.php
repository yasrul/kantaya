<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use app\models\Model;
use app\models\Surat;
use app\models\search\SuratSearch;
use app\models\SuratTujuan;

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
        $modelsTujuan = [new SuratTujuan()];
     
        if ($modelSurat->load(Yii::$app->request->post())) {
            $modelSurat->id_pengirim = Yii::$app->user->identity->unit_id;
            $modelSurat->id_perekam = Yii::$app->user->identity->unit_id;
            
            $modelsTujuan = Model::createMultiple(SuratTujuan::className());
            Model::loadMultiple($modelsTujuan, Yii::$app->request->post());
            //assign default id_surat
            
            foreach ($modelsTujuan as $modelTujuan) {
                $modelTujuan->id_surat = 0;
            }
   
            // validate all models
            $valid = $modelSurat->validate();
            $valid = Model::validateMultiple($modelsTujuan) && $valid;
            
            if ($valid) {
                // mulai database transaction
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // simpan master record                   
                    if ($flag = $modelSurat->save(false)) {
                        // simpan details record
                        foreach ($modelsTujuan as $modelTujuan) {
                            $modelTujuan->id_surat = $modelSurat->id;
                            if (! ($flag = $modelTujuan->save(false))) {
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
                    } 
                } catch (Exception $ex) {
                    // penyimpanan gagal, rollback database transaction
                    $transaction->rollBack();
                    throw $ex;
                }
            }
           
        } 
        // inisialisai id 
        // diperlukan untuk form master-detail
        $modelSurat->id = 0;
        return $this->render('create', [
            'modelSurat' => $modelSurat,
            'modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan()] : $modelsTujuan,
        ]);
             
    }
    
    public function actionUpdate($id) {
        $modelSurat = $this->findModel($id);
        $modelsTujuan = $modelSurat->tujuan;
        
        if ($modelSurat->load(Yii::$app->request->post())) {
            
            $oldIDs = ArrayHelper::map($modelsTujuan, 'id', 'id');
            $modelsTujuan = Model::createMultiple(SuratTujuan::className(), $modelsTujuan);
            Model::loadMultiple($modelsTujuan, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTujuan, 'id', 'id')));
            
            //validate all model
            $valid = $modelSurat->validate();
            $valid = Model::validateMultiple($modelsTujuan) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                
                try {
                    if ($flag = $modelSurat->save()) {
                        if(!empty($deletedIDs)) {
                            SuratTujuan::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsTujuan as $modelTujuan) {
                            $modelTujuan->id_surat = $modelSurat->id;
                            if (! ($flag = $modelTujuan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelSurat->id]);
                    }
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw $ex;
                }
            }
        } 
        return $this->render('update', [
            'modelSurat' => $modelSurat,
            'modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan] : $modelsTujuan 
        ]);
        
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
