<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Surat;
use app\models\Regin;
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
                        'roles' => ['@']
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
        $modelTujuan = new TujuanSurat();
        $modelRegin = new Regin();
        
        $postData = Yii::$app->request->post();
        if ($modelSurat->load($postData) && $modelTujuan->load($postData) && $modelRegin->load($postData)) {
            $isValid = Model::validateMultiple([$modelSurat, $modelRegin]);
            if ($isValid) {
                $modelSurat->save();
                $modelTujuan->save();
                $modelRegin->save();
                return $this->redirect(['view','id' => $modelSurat->id]);
            }
        } else {
            return $this->render('create', [
                'modelSurat'=>$modelSurat, 
                'modelTujuan'=>$modelTujuan, 
                'modelRegin'=>$modelRegin
            ]);
        }
    }
}
