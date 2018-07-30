<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
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
   
            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsTujuan), 
                        ActiveForm::validate($modelSurat));
            }
            // validate all models
            $valid = $modelSurat->validate();
            $valid = Model::validateMultiple($modelsTujuan) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    //simpan FileDokumen
                    $modelSurat->uploadFiles();
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
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelSurat->id]);
                    } 
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw $ex;
                }
            }
           
        } 
        // inisialisai id 
        // diperlukan untuk form master-detail
        //$modelSurat->id = 0;
        return $this->render('create', [
            'modelSurat' => $modelSurat,
            'modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan()] : $modelsTujuan,
        ]);
             
    }
    
    public function actionUpdate($id) {
        $modelSurat = $this->findModel($id);
        $modelsTujuan = $modelSurat->tujuan;
        $previewConfig = [];
        $urlfiles = [];
        
        if (isset($modelSurat->dokumen)) {
            $dokumens = explode("//", $modelSurat->dokumen);         
            for ($i=0; $i < count($dokumens)-1; $i++) {
                $urlfiles[] = Url::to('/web/docfiles/'.$dokumens[$i]);
                $previewConfig[] = [
                    'caption'=>$dokumens[$i],
                    'url' => Url::to(['delete-file','id' => $modelSurat->id,'file'=>$dokumens[$i]]) ,
                ];
            }
        }
        
        if ($modelSurat->load(Yii::$app->request->post())) {
            
            $oldIDs = ArrayHelper::map($modelsTujuan, 'id', 'id');
            $modelsTujuan = Model::createMultiple(SuratTujuan::className(), $modelsTujuan);
            Model::loadMultiple($modelsTujuan, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTujuan, 'id', 'id')));
            
            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsTujuan), 
                        ActiveForm::validate($modelSurat));
            }
            //validate all model
            $valid1 = $modelSurat->validate();
            $valid2 = Model::validateMultiple($modelsTujuan);
            $valid = $valid1 && $valid2;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    //simpan file dokumen
                    $modelSurat->uploadFiles();
                    //simpan master file
                    if ($flag = $modelSurat->save(false)) {
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
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return $this->render('update', [
                    'modelSurat' => $modelSurat,
                    'modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan] : $modelsTujuan,
                    'urlFiles' => $urlfiles,
                    'previewConfig' => $previewConfig,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }
        } 
        return $this->render('update', [
            'modelSurat' => $modelSurat,
            'modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan] : $modelsTujuan,
            'urlFiles' => $urlfiles,
            'previewConfig' => $previewConfig,
        ]);
        
    }
    
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    
    public function actionDeleteFile($id, $file) {
        
        $model = $this->findModel($id);
        $old_dokumens = explode("//", $model->dokumen);
        
        $pathfile = Yii::$app->basePath.'/web/docfiles/'.$file;
        
        if(empty($file) || !file_exists($pathfile)) {
            return FALSE;
        }
        
        if(!unlink($pathfile)) {
            return FALSE;
        }
        $dokumens = '';
        for ($i=0; $i < count($old_dokumens)-1; $i++) {
            if ($old_dokumens[$i]!== $file) {
                $dokumens .= $old_dokumens[$i].'//';
            }
        }
        $model->dokumen = $dokumens;
        if ($model->save()) {        
            return TRUE;
        }
    }
    
    public function actionDownload($filename) {
   
        $path = Yii::getAlias('@app').'/web/docfiles/'.$filename;
        
        if(file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }
    }

    protected function findModel($id) {
        if (($model = Surat::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException ('The requested page does not exist.');
        }
    }
}
