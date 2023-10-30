<?php

    namespace app\controllers;

    use app\models\Approved;
    use app\models\Denied;
    use app\models\DonateBlood;
    use app\models\RequestBlood;
    use app\models\User;
    use Throwable;
    use Yii;
    use yii\db\StaleObjectException;
    use yii\helpers\Url;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\data\ActiveDataProvider;

    /** @var DonateBlood $donate */
    /** @var RequestBlood $request */

    /** @var User $user */
    class UserController extends Controller
    {
        public function actionDashboard()
        {

            return $this->render('dashboard');
        }

        public function actionUserSubmissions()
        {
            $requestDataProvider = new ActiveDataProvider([
                'query' => RequestBlood::find()->where(['user_id' => Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 4
                ]
            ]);

            $donateDataProvider = new ActiveDataProvider([
                'query' => DonateBlood::find()->where(['user_id' => Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 4
                ]
            ]);

            $donateDataProvider->pagination->pageParam = 'donate-page';
            $requestDataProvider->pagination->pageParam = 'request-page';
            return $this->render('userSubmissions', ['requestDataProvider' => $requestDataProvider, 'donateDataProvider' => $donateDataProvider]);
        }

        public function actionDelete($id, $table)
        {
            $session = Yii::$app->session;
            $this->findModel($id, $table)->delete();
            $session->setFlash('successMessage', 'record has been successfully deleted');

            return $this->redirect(['user/user-submissions']);

        }

        public function findModel($id, $table = null)
        {
            $tables = [
                'donateblood' => DonateBlood::class,
                'user' => User::class,
                'requestblood' => RequestBlood::class,
            ];

            if ($table && array_key_exists($table, $tables)) {
                return $tables[$table]::findOne(['id' => $id]);

            }

            foreach ($tables as $tableName => $tableClass) {
                if (($table = $tableClass::findOne(['id' => $id])) !== null) {
                    return $table;
                }
            }

            // Return null if no model is found
            return null;
        }

        public function actionView($id, $table)
        {
            $model = $this->findModel($id, $table);
            return $this->renderAjax('_userItem', [
                'model' => $model,
            ]);
        }

        public function actionUpdate($id, $table)
        {
            $session = Yii::$app->session;
            $model = $this->findModel($id, $table);
            $model->updated_at = date('Y-m-d H:i:s');

            if (Yii::$app->request->isGet) {
                Url::remember($this->request->referrer, $this->action->uniqueId);
            }

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $session->setFlash('successMessage', 'record has been successfully updated');
                return $this->redirect(['user/user-submissions']);
            }
            $session->setFlash('errorMessages', $model->getErrors());
            return $this->renderAjax('userUpdate', [
                'model' => $model,
            ]);
        }

        public function actionRequestBlood()
        {

            $postData = Yii::$app->request->post();
            $blood_request = new RequestBlood();
            $user_id = Yii::$app->user->id;
            $user = User::findOne($user_id);
            $user->isRequester = $user->isRequester ?: true;
            $user->updated_at = date('Y-m-d H:i:s');
            $blood_request->user_id = $user_id;
            $blood_request->attributes = $postData;
            $session = Yii::$app->session;

            if ($user->validate() && $user->save() && $blood_request->validate() && $blood_request->save()) {
                $session->setFlash('successMessage', 'Your request has been submitted!');
                $_POST = [];
                return $this->redirect(['user/dashboard']);
            }

            $session->setFlash('errorMessages', $user->getErrors());
            return $this->redirect(['user/dashboard']);
        }

        public function actionDonateBlood()
        {

            $postData = Yii::$app->request->post();
            $donate_blood = new DonateBlood();
            $user_id = Yii::$app->user->id;
            $user = User::findOne($user_id);
            $user->isDonor = $user->isDonor ?: true;
            $user->updated_at = date('Y-m-d H:i:s');
            $donate_blood->user_id = $user_id;
            $donate_blood->attributes = $postData;
            $session = Yii::$app->session;

            if ($user->validate() && $user->save() && $donate_blood->validate() && $donate_blood->save()) {
                $session->setFlash('successMessage', 'Your offer to donate blood has been received!');
                $_POST = [];
                return $this->redirect(['user/dashboard']);
            }

            $session->setFlash('errorMessages', $user->getErrors());
            return $this->redirect(['user/dashboard']);
        }


    }