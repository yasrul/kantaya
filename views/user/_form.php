<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Departments;
use app\models\Role;
use app\models\StatusUser;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'style'=>'width: 700px']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'style'=>'width: 700px']) ?>

    <?= $form->field($model, 'role_id')->dropDownList(Role::getRoleList(), [
        'prompt'=>'[ Pilih Role ]',
        'style'=>'width: 300px',
    ]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(StatusUser::getStatusList(), [
        'prompt'=>'[ Pilih Status ]',
        'style'=>'width: 300px',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
