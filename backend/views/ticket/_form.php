<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Board;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form"><?php $form = ActiveForm::begin(); ?> <?= $form->field($model, 'id')->textInput() ?>

<?php
    $boards = Board::find()->all();
    $boardItems = ArrayHelper::map($boards, 'id', 'title');
    echo $form->field($model, 'board_id')->dropDownList($boardItems);

    echo $form->field($model, 'column_id')->textInput();
    echo $form->field($model, 'title')->textarea(['rows' => 1]);
    echo $form->field($model, 'description')->textarea(['rows' => 4]);
    echo $form->field($model, 'protocol')->textarea(['rows' => 4]);
?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?></div>
