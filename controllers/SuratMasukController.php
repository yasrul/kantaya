<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\Model;
use app\models\Surat;
use app\models\Disposisi;
use app\models\search\SuratSearch;
use app\models\TujuanSurat;
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
                'only' => ['index','create','update','delete','teruskan'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','teruskan'],
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
                    $upload = $modelSurat->uploadFile();
                    // simpan master record                   
                    if ($flag = $modelSurat->save(false)) {
                        //simpan file
                        if ($upload) {
                            $path = $modelSurat->getPathFile();
                            $upload->saveAs($path);
                        }
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
    
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    
    public function actionTeruskan($idSurat) {
        $modelsTujuan = Model::createMultiple(SuratTujuan::className());
        if (Model::loadMultiple($modelsTujuan, Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($modelsTujuan as $modelTujuan) {
                    $modelTujuan->id_surat = $idSurat;
                    $modelTujuan->id_penerus = Yii::$app->user->identity->id_unit;
                    $modelTujuan->tgl_diteruskan = date('Y-m-d');
                    if ($flag = $modelTujuan->save(false)) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $idSurat]);
                    } else {
                        $transaction->rollBack();
                        break;
                    }
                } 
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
            
        } 
        return $this->renderAjax('teruskan', [(empty($modelsTujuan)) ? [New SuratTujuan()] : $modelsTujuan,]);
    }

    protected function findModel($id) {
        if (($model = Surat::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException ('The requested page does not exist.');
        }
    }
}
