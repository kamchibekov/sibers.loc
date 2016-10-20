<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-admin">

    <h1><?= Html::encode($this->title); ?></h1>

    <?php
        Modal::begin([
            'header' => '<h4>Create User</h4>',
            'toggleButton' => ['label' => 'Create User','class' => 'btn btn-success'],
        ]);

        Pjax::begin(['id' => 'crud_user_form']);
        echo '<input type="hidden" id="pjax-status" value="' . $status .'">';

        $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]);

        echo  $form->field($create_model, 'username')->textInput(['maxlength' => true]);

        echo  $form->field($create_model, 'email')->textInput(['maxlength' => true]);

        echo  $form->field($create_model, 'password')->passwordInput(['maxlength' => true]);

        echo Html::submitButton('Create',['class' => 'btn btn-success']);

        ActiveForm::end(); Pjax::end();  Modal::end();
    ?>

    <?php Pjax::begin(['id' => 'gridview']); ?>
    <?=  GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                'email:email',
                'password',

                ['class' => 'yii\grid\ActionColumn'],
            ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>


<?php


    $this->registerJs(
        '$("document").ready(function(){
                $("#crud_user_form").on("pjax:end", function() {
                    $.pjax.reload({container:"#gridview"});
                   var a =  $("#pjax-status").val();
                    if(a == 1){       
                        $(".close").click();
                    }

               });
             });
          ');
?>
