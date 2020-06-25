<?php

namespace app\controllers;

use app\models\UserAccount;
use app\models\ZadarmaAPIRequester;
use app\models\ZadarmaNotificationReceiver;
use Yii;
use app\models\UserCall;
use app\models\UserCallSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserCallController implements the CRUD actions for UserCall model.
 */
class UserCallController extends Controller
{

    public function actionFetchStat()
    {
        if ($statsArr = ZadarmaAPIRequester::getStatistic()) {
            $allCalls = UserCall::find()->all();
            $arrCalls = ArrayHelper::toArray($allCalls, [
                'app\models\UserCall' => ['id']
            ]);
            $callIds = ArrayHelper::getColumn($arrCalls, 'id');

            foreach ($statsArr as $item) {
                if (in_array($item['id'], $callIds)) {
                    continue;
                }

                $mentor = UserAccount::findOne(['sip_id' => $item['sip']]);
                $user = UserAccount::findOne(['phone' => $item['to']]);

                $call = new UserCall(
                    [
                        'id' => $item['id'],
                        'account_id' => $user->id,
                        'mentor_id' => $mentor->id,
                        'sip_id' => $item['sip'],
                        'created_at' => $item['callstart'],
                        'city' => $item['description'],
                        'success' => $item['hangupcause'] == '16' ? 1 : 0,
                        'cost_per_minute' => $item['cost'],
                        'duration' => $item['billseconds']
                    ]
                );

                if (!$call->save()) {
                    return 'Failed to save statistic';
                }
            }
            $this->goHome();
        } else {
            return 'Failed to get statistic';
        }
    }

    public function actionListenWebhook()
    {
        $request = Yii::$app->request;

        if (!$request->get('zd_echo')) {
            return 'It is not webhook';
        }

        if (ZadarmaNotificationReceiver::saveCall($request->post())) {
            return 'Success';
        } else {
            return 'Failed to handle webhook';
        }
    }


    public function actionIndex()
    {
        $searchModel = new UserCallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserCall model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserCall model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserCall();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserCall model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCall model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserCall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCall::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
