<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\authentication\rest\controllers;

use Yii;
use yii\web\MethodNotAllowedHttpException;
use yii\web\ServerErrorHttpException;
use yuncms\authentication\rest\models\Authentication;
use yuncms\rest\Controller;

/**
 * Class AuthenticationController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class AuthenticationController extends Controller
{
    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return array_merge(parent::verbs(), [
            'authentication' => ['GET', 'POST'],
        ]);
    }

    /**
     * 实名认证
     * @return null|Authentication
     * @throws MethodNotAllowedHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAuthentication()
    {
        if (Yii::$app->request->isPost) {
            $model = Authentication::findByUserId(Yii::$app->user->getId());
            $model->scenario = Authentication::SCENARIO_UPDATE;
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (($model->save()) != false) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            return $model;
        } else if (Yii::$app->request->isGet) {
            return Authentication::findByUserId(Yii::$app->user->getId());
        }
        throw new MethodNotAllowedHttpException();
    }
}