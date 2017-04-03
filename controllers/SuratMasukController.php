<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\Surat;
use app\models\Register;
use app\models\TujuanSurat;

/**
 * Description of SuratMasukController
 *
 * @author yasrul
 */
class SuratMasukController extends Controller 
{
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
        return $this->render('index');
    }
    
    public function actionCreate() {
        $modelSurat = new Surat();
        $modelTujuan = [new TujuanSurat];
        $modelRegister = [new Register];
        
        $postData = Yii::$app->request->post();
        if ($modelSurat->load($postData) && $modelTujuan->load($postData) && $modelRegister->load($postData)) {
            
            $modelSurat->id = Surat::maxIdSurat($modelSurat->tgl_surat);
            $modelTujuan->id_surat = $modelSurat->id;
            $modelRegister->id_unit = Yii::$app->user->identity->unit_id;
            $modelRegister->id_surat = $modelSurat->id;
            
            $isValid = Model::validateMultiple([$modelSurat, $modelTujuan, $modelRegister]);
            if ($isValid) {
                $modelSurat->save();
                $modelTujuan->save();
                $modelRegister->save();
                return $this->redirect(['view','id' => $modelSurat->id]);
            }
        } else {
            return $this->render('create', [
                'modelSurat'=>$modelSurat, 
                'modelTujuan'=>$modelTujuan,
                'modelRegister'=>$modelRegister,
            ]);
        }
        return $this->render('create', [
                'modelSurat'=>$modelSurat, 
                'modelTujuan'=>$modelTujuan,
                'modelRegister'=>$modelRegister,
            ]);
    }
}
