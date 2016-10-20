<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Country;

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

        echo  '<div class="dropdown col-lg-5">';

        echo  $form->field($create_model, 'country_name')->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'));

        echo  '</div><br><br><br><br><br>';

        echo  $form->field($create_model, 'email')->textInput(['maxlength' => true]);

        echo  $form->field($create_model, 'password')->passwordInput(['maxlength' => true]);

        echo Html::submitButton('Create',['class' => 'btn btn-success']);

        ActiveForm::end(); Pjax::end();  Modal::end();
    ?>


    <?php
    Modal::begin([
        'header' => '<h4>Create User</h4>',
        'toggleButton' => ['label' => 'Edit User','class' => 'btn btn-primary'],
    ]);

    Pjax::begin(['id' => 'crud_user_form']);
    echo '<input type="hidden" id="pjax-status" value="' . $status .'">';

    $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]);

    echo  $form->field($create_model, 'username')->textInput(['maxlength' => true]);

    echo  '<div class="dropdown col-lg-5">';

    echo  $form->field($create_model, 'country_name')->dropDownList(ArrayHelper::map(Country::find()->all(), 'name', 'name'));

    echo  '</div><br><br><br><br><br>';

    echo  $form->field($create_model, 'email')->textInput(['maxlength' => true]);

    echo  $form->field($create_model, 'password')->passwordInput(['maxlength' => true]);

    echo Html::submitButton('Update',['class' => 'btn btn-primary']);

    ActiveForm::end(); Pjax::end();  Modal::end();
    ?>

    <?php Pjax::begin(['id' => 'gridview']); ?>

    <?=  GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                [
                    'label' => 'Country',
                    'value' => function($data){;
                        return Country::findOne(['id' => $data->country_id])->name;
                    }
                ],
                'email:email',
                'password',

                ['class' => 'yii\grid\ActionColumn'],
            ]
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

      //         console.log($("#delete_success").val());
/*
               if($("#delete_success").val() == 200)
               {
                    $("#crud_user_form").on("pjax:end", function() {
                        $.pjax.reload({container:"#gridview"});
                    });
               }
*/
             });
          ');
?>
