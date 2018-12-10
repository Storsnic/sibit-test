<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\InvestForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
		if(\Yii::$app->request->isAjax) {
			var_dump($_POST);
			return 'Запрос принят!';
		}
		
		$model = new InvestForm();
		return $this->render('invest', [
			'model' => $model,
		]);
		//return $this->render('index');
    }
	
}
