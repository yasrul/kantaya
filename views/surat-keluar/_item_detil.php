<?php
/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
?>

<tr><td><?= $form->field($model, "[$key]id_penerima", ['class'=>'form-control','required' => true])->textInput(); ?></td></tr>
<tr><td><?= $form->field($model, "[$key]penerima_manual")->textInput(); ?></td></tr>
<tr><td><?= $form->field($model, "[$key]alamat_manual")->textInput() ; ?></td></tr>
        