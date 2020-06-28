<?php

namespace app\controllers;

use app\models\User;
use app\helpers\api\Zadarma;
use Yii;
use app\models\Call;
use app\models\CallSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CallController implements the CRUD actions for Call model.
 */
class CallController extends Controller
{

    public function actionFetchStat()
    {
        if ($statsArr = Zadarma::getStatistic()) {
            $allCalls = Call::find()->all();
            $arrCalls = ArrayHelper::toArray($allCalls, [
                'app\models\Call' => ['id']
            ]);
            $callIds = ArrayHelper::getColumn($arrCalls, 'id');

            foreach ($statsArr as $item) {
                if (in_array($item['id'], $callIds)) {
                    continue;
                }

                $mentor = User::findOne(['sip_id' => $item['sip']]);
                $user = User::findOne(['phone' => $item['to']]);

                $call = new Call(
                    [
                        'id'              => $item['id'],
                        'account_id'      => $user->id,
                        'mentor_id'       => $mentor->id,
                        'sip_id'          => $item['sip'],
                        'created_at'      => $item['callstart'],
                        'city'            => $item['description'],
                        'success'         => $item['hangupcause'] === '16' ? 1 : 0,
                        'cost_per_minute' => $item['cost'],
                        'duration'        => $item['billseconds']
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

        if ($this->saveCall($request->post())) {
            return 'Success';
        } else {
            return 'Failed to handle webhook';
        }
    }

    private function saveCall($params)
    {
        if ($params['event'] === 'NOTIFY_END') {
            $mentor = User::findOne(['phone' => $params['caller_id']]);
            $user = User::findOne(['phone' => $params['called_did']]);
        } elseif ($params['event'] === 'NOTIFY_OUT_END') {
            $mentor = User::findOne(['phone' => $params['destination']]);
            $user = User::findOne(['phone' => $params['caller_id']]);
        } else {
            return false;
        }

        $call = new Call(
            [
                'id'              => $params['pbx_call_id'],
                'account_id'      => $user->id,
                'mentor_id'       => $mentor->id,
                'sip_id'          => $mentor->sip_id,
                'created_at'      => $params['call_start'],
                'city'            => null,
                'success'         => $params['disposition'] === 'answered' ? 1 : 0,
                'cost_per_minute' => null,
                'duration'        => $params['duration']
            ]
        );

        return $call->save();
    }


    public function actionIndex()
    {
        $searchModel = new CallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Call model.
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
     * Creates a new Call model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Call();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Call model.
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
     * Deletes an existing Call model.
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
     * Finds the Call model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Call the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Call::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
