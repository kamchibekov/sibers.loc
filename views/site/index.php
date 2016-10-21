<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\models\Country;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-admin">

    <h1><?= Html::encode($this->title); ?></h1>

    <?php

    // using bootstrap modal to send ajax request
        Modal::begin([
            'id' => 'create-modal',
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


    <?php Modal::begin([
        'id' => 'view-modal',
        'header' => '<h4 class="modal-title">User View</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

    ]); ?>



    <?php Modal::end(); ?>


    <?php Pjax::begin(['id' => 'gridview', 'enablePushState'=>FALSE]); ?>
<br>
    <?=  GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                [
                    'label' => 'Country',
                    'value' => function($data){
                        return Country::findOne(['id' => $data->country_id])->name;
                    }
                ],

             /*   [
                    'label' => 'Profile',
                    'format' => 'raw',
                    'value' => function($data){
                     return '<a tabindex="0" class="glyphicon glyphicon-th" role="button" data-toggle="popover" data-trigger="focus"
                          title="Profile" data-content="' .
                     "First Name: " .
                     "Last Name: " .
                     "Birth Date: " .
                     "Gender: " .
                     "Country: ". Country::findOne(['id' => $data->country_id])->name .  '"></a>
                             ';
                    }
                ],  */

                'email:email',
                'password',
                $actionColumn = ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                     /*
                        'view' => function ($url, $model, $id) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'View'),

                            ]);
                        },

                        'update' => function ($url, $model, $id) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                                'title' => Yii::t('app', 'Edit'),
                            ]);
                        },

                       */
                    ],
                ],
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
             });
          ');
?>
