<?php

namespace app\controllers;

use Yii;
use app\models\Disposisi;
use app\models\search\DisposisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Model;
use app\models\Surat;
use app\models\DisposisiTujuan;

/**
 * DisposisiController implements the CRUD actions for Disposisi model.
 */
class DisposisiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Disposisi models.
     * @return mixed
     */
    public function actionIndex($io)
    {
        $searchModel = new DisposisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $io);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'io'=>$io
        ]);
    }

    /**
     * Displays a single Disposisi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Disposisi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $modelSurat = $this->findSurat($id);
        $modelDispo = new Disposisi;
        $modelsTujuan = [new DisposisiTujuan];
        
        if ($modelDispo->load(Yii::$app->request->post())) {
            $modelDispo->id_surat = $modelSurat->id;
            $modelDispo->id_pemberi = Yii::$app->user->id;
            
            $modelsTujuan = Model::createMultiple(DisposisiTujuan::className());
            Model::loadMultiple($modelsTujuan, Yii::$app->request->post());
            foreach ($modelsTujuan as $modelTujuan) {
                $modelTujuan->id_disposisi = 0;
            }
            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::Format_JSON;
                return ArrayHelper::merge(ActiveForm::validateMultiple($modelsTujuan),
                    ActiveForm::validate($modelDispo)
                );
            }
            //validate all model
            $valid1 = $modelDispo->validate();
            $valid2 = Model::validateMultiple($modelsTujuan);
            $valid = $valid1 && $valid2;
            
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    //simpan master record
                    if ($flag = $modelDispo->save(false)) {
                        //simpan detil record
                        foreach ($modelsTujuan as $modelTujuan) {
                            $modelTujuan->id_disposisi = $modelDispo->id;
                            if ( ! ($flag = $modelTujuan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        //sukses, commit transaction
                        $transaction->commit();
                        return $this->redirect(['surat-masuk/view', 'id' => $modelSurat->id]);
                    } else {
                        return $this->render('create', [
                            'modelDispo' => $modelDispo,
                            'modelsTujuan' => $modelsTujuan,
                            'id_surat' => $modelSurat->id,
                        ]);
                    }
                    
                } catch (Exception $ex) {
                    //penyimpanan gagal, rollback transaction
                    $transaction->rollBack();
                    throw $ex;
                }
            } else {
                return $this->render('create', [
                    'modelDispo' => $modelDispo,
                    'modelsTujuan' => $modelsTujuan,
                    'id_surat' => $modelSurat->id,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }
            
        } else {
            $modelDispo->id = 0;
            return $this->render('create', [
                'modelDispo' => $modelDispo,
                'modelsTujuan' => $modelsTujuan,
                'id_surat' => $modelSurat->id,
            ]);
        }
    }

    /**
     * Updates an existing Disposisi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelDispo = $this->findModel($id);
        $modelsTujuan = $modelDispo->tujuan;
        
        if ($modelDispo->load(Yii::$app->request->post())) {
            
            $oldIDs = ArrayHelper::map($modelsTujuan, 'id', 'id');
            $modelsTujuan = Model::createMultiple(DisposisiTujuan::className(), $modelsTujuan);
            Model::loadMultiple($modelsTujuan, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTujuan, 'id', 'id')));
            
            //ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsTujuan), 
                        ActiveForm::validate($modelDispo));
            }
            //validate all model
            $valid1 = $modelDispo->validate();
            $valid2 = Model::validateMultiple($modelsTujuan);
            $valid = $valid1 && $valid2;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelDispo->save(false)) {
                        if(!empty($deletedIDs)) {
                            DisposisiTujuan::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsTujuan as $modelTujuan) {
                            $modelTujuan->id_disposisi = $modelDispo->id;
                            if (! ($flag = $modelTujuan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelDispo->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return $this->render('update', [
                    'modelDispo' => $modelDispo,
                    'modelsTujuan' => (empty($modelsTujuan)) ? [New DisposisiTujuan] : $modelsTujuan,
                    'error' => 'valid1: '.print_r($valid1,true).' - valid2: '.print_r($valid2,true),
                ]);
            }
        } 
        return $this->render('update', [
            'modelDispo' => $modelDispo,
            'modelsTujuan' => (empty($modelsTujuan)) ? [New DisposisiTujuan] : $modelsTujuan 
        ]);
    }

    /**
     * Deletes an existing Disposisi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Disposisi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Disposisi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Disposisi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findSurat($id) {
        if (($model = Surat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
