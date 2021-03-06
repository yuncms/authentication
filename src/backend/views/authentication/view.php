<?php

use yuncms\helpers\Html;
use yuncms\widgets\DetailView;
use yuncms\admin\widgets\Box;
use yuncms\admin\widgets\Toolbar;
use yuncms\admin\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model yuncms\authentication\models\Authentication */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yuncms/authentication', 'Manage Authentication'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 authentication-view">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('yuncms/authentication', 'Manage Authentication'),
                            'url' => ['index'],
                        ],

                        [
                            'label' => Yii::t('yuncms/authentication', 'Update Authentication'),
                            'url' => ['update', 'id' => $model->user_id],
                            'options' => ['class' => 'btn btn-primary btn-sm']
                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">

                </div>
            </div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user_id',
                    'user.nickname',
                    'real_name',
                    'id_card',
                    'passport_cover:image',
                    'passport_person_page:image',
                    'passport_self_holding:image',
                    [
                        'header' => Yii::t('yuncms/authentication', 'Authentication'),
                        'attribute' => 'status',
                        'value' => function ($model) {
                            if ($model->status == 0) {
                                return Yii::t('yuncms/authentication', 'Pending review');
                            } elseif ($model->status == 1) {
                                return Yii::t('yuncms/authentication', 'Rejected');
                            } elseif ($model->status == 2) {
                                return Yii::t('yuncms/authentication', 'Authenticated');
                            }
                            return null;
                        },
                        'format' => 'raw',
                    ],
                    'failed_reason',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>
</div>