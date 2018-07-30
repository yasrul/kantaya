<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use app\models\Model;
use app\models\Surat;
use app\models\Disposisi;
use app\models\search\SuratSearch;
use app\models\SuratTujuan;
use app\models\DisposisiTujuan;

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
                'only' => ['index','create','update','delete','teruskan','download'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','teruskan','download'],
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
        
        $modelSurat = $this->findModel($id);
        $previewConfig = [];
        $urlfiles = [];
        
        if ($tujuan = SuratTujuan::find()->where(['id_surat'=>$id, 'id_penerima'=>Yii::$app->user->identity->unit_id])->one()) {
            if ($tujuan->tgl_diterima == NULL) {
                date_default_timezone_set('Asia/Makassar');
                $tujuan->tgl_diterima = date('Y-m-d H:i:s');
                $tujuan->save();
            }
        }
        
        if (isset($modelSurat->dokumen)) {
            $dokumens = explode("//", $modelSurat->dokumen);         
            for ($i=0; $i < count($dokumens)-1; $i++) {
                $urlfiles[] = Url::toRoute('web/docfiles/'.$dokumens[$i]);
                $previewConfig[] = [
                    'caption'=>$dokumens[$i],
                    'url' => Url::to(['delete-file','id' => $modelSurat->id,'file'=>$dokumens[$i]]) ,
                ];
            }
        }
        return $this->render('view', [
            'modelSurat' => $modelSurat,
            'urlFiles' => $urlfiles,
            'previewConfig' => $previewConfig,
        ]);
    }

     /**
     * Creates a new Surat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelSurat = new Surat();
        $modelTujuan = new SuratTujuan();
     
        if ($modelSurat->load(Yii::$app->request->post()) && $modelTujuan->load(Yii::$app->request->post())) {
            
            $modelSurat->id_perekam = Yii::$app->user->identity->unit_id;
            $modelTujuan->id_surat = 0;

            // validate all models
            $valid1 = $modelSurat->validate();
            $valid2 = $modelTujuan->validate();
            $valid = $valid1 && $valid2;
            
            if ($valid) {               
                // mulai database transaction
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    //simpan FileDokumen
                    $modelSurat->uploadFiles();
                    // simpan master record                   
                    if ($flag = $modelSurat->save(false)) {                      
                        // simpan details record
                        $modelTujuan->id_surat = $modelSurat->id;
                        $modelTujuan->id_penerima = Yii::$app->user->identity->unit_id;
                        if (! ($flag = $modelTujuan->save(false))) {
                                $transaction->rollBack();
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
                } catch (Exception $e) {
                    // penyimpanan gagal, rollback database transaction
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return $this->render('create', [
                    'modelSurat' => $modelSurat,
                    'modelTujuan' => $modelTujuan,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }         
        } else {
            // render view
            return $this->render('create', [
                'modelSurat' => $modelSurat,
                'modelTujuan' => $modelTujuan,
            ]);
        }
       
    }

    public function actionUpdate($id) {
        $modelSurat = $this->findModel($id);
        $modelTujuan = SuratTujuan::find()->where(['id_surat' => $modelSurat->id, 'id_penerima' => Yii::$app->user->identity->unit_id])->one();
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
     
        if ($modelSurat->load(Yii::$app->request->post()) && $modelTujuan->load(Yii::$app->request->post())) {
                      
            $modelTujuan->id_surat = $modelSurat->id;

            // validate all models
            $valid1 = $modelSurat->validate();
            $valid2 = $modelTujuan->validate();
            $valid = $valid1 && $valid2;
            
            if ($valid) {             
                // mulai database transaction
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    //simpan file dokumen
                    $modelSurat->uploadFiles();
                    // simpan master record                   
                    if ($flag = $modelSurat->save(false)) {
                        // simpan details record                      
                            $modelTujuan->id_surat = $modelSurat->id;
                            $modelTujuan->id_penerima = Yii::$app->user->identity->unit_id;
                            $modelTujuan->status_tujuan = 1;
                            if (! ($flag = $modelTujuan->save(false))) {
                                $transaction->rollBack();
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
                } catch (Exception $e) {
                    // penyimpanan gagal, rollback database transaction
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return $this->render('update', [
                    'modelSurat' => $modelSurat,
                    'modelTujuan' => $modelTujuan,
                    'urlFiles' => $urlfiles,
                    'previewConfig' => $previewConfig,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }         
        } else {            
            // render view
            return $this->render('update', [
                'modelSurat' => $modelSurat,
                'modelTujuan' => $modelTujuan,
                'urlFiles' => $urlfiles,
                'previewConfig' => $previewConfig,
            ]);
        }
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
    
    public function actionTeruskan($id) {
        $modelsTujuan = Model::createMultiple(SuratTujuan::className());
        if (Model::loadMultiple($modelsTujuan, Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($modelsTujuan as $modelTujuan) {
                    $modelTujuan->id_surat = $id;
                    $modelTujuan->id_penerus = Yii::$app->user->identity->unit_id;
                    $modelTujuan->status_tujuan = 3;
                    $modelTujuan->tgl_diteruskan = date('Y-m-d');
                    if (! ($flag = $modelTujuan->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $id]);
                } 
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
            
        } 
        return $this->renderAjax('teruskan', ['modelsTujuan' => (empty($modelsTujuan)) ? [New SuratTujuan()] : $modelsTujuan,]);
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
