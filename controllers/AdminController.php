<?php

    namespace app\controllers;

    use app\models\Approved;
    use app\models\Denied;
    use app\models\DonateBlood;
    use app\models\RequestBlood;
    use app\models\User;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\web\Controller;

    class AdminController extends Controller
    {
        public function behaviors()
        {

            return ['access' => ['class' => AccessControl::class, 'only' => ['logout'], 'rules' => [['actions' => ['logout'], 'allow' => true, 'roles' => ['@'],],],],
                'verbs' => ['class' => VerbFilter::class, 'actions' => ['logout' => ['post'],],],
            ];
        }

        public function actions()
        {
            return ['error' => ['class' => 'yii\web\ErrorAction',], 'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,],];
        }

        public function actionAdminDashboard()
        {
            return $this->render('adminDashboard');
        }

        public function actionRegister()
        {
            return $this->render('register');

        }

        public function actionSignUp()
        {
            $postData = Yii::$app->request->post();
            $user = new User(['scenario' => User::SCENARIO_REGISTER]);
            $user->attributes = $postData;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password); //hash pass before sending to db
            $session = Yii::$app->session;
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('admin');

            if ($user->validate() && $user->save()) {
                $auth->assign($role, $user->getId());
                $session->setFlash('successMessage', 'Your Account has been created.');
                return $this->redirect(['site/login']);

            }

            $session->setFlash('errorMessages', $user->getErrors());
            return $this->redirect(['admin/register']);

        }

        public function actionDisplayUsers($page = null)
        {
            $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
                'pagination' => [
                    'pageSize' => 2,
                    'page' => $page
                ]
            ]);

            return $this->renderPartial('_users', ['dataProvider' => $dataProvider]);

        }

        public function actionDisplayRequests($page = null)
        {
            $dataProvider = new ActiveDataProvider([
                'query' => RequestBlood::find(),
                'pagination' => [
                    'pageSize' => 2,
                    'page' => $page
                ]
            ]);
            return $this->renderPartial('_requests', ['dataProvider' => $dataProvider]);
        }

        public function actionDisplayDonations($page = null)
        {
            $dataProvider = new ActiveDataProvider([
                'query' => DonateBlood::find(),
                'pagination' => [
                    'pageSize' => 2,
                    'page' => $page
                ]
            ]);
            return $this->renderPartial('_donations', ['dataProvider' => $dataProvider]);
        }

        public function actionDelete($id)
        {
            $session = Yii::$app->session;
            $this->findModel($id)->delete();
            $session->setFlash('successMessage', 'record has been successfully deleted');

            return $this->redirect(['site/admin-dashboard']);

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
            //return null if no model is found
            return null;
        }

        public function actionDenyRequest($id)
        {
            $request = RequestBlood::findOne($id);
            $request->denied = true;
            $denied_request = new Denied();
            $denied_request->request_or_donation = 'request';
            $denied_request->denied_by = Yii::$app->user->identity->name;
            $denied_request->user_id = $request->user_id;
            $denied_request->request_id = $request->id;

            if ($request->save() && $denied_request->save()) {
                Yii::$app->session->setFlash('successMessage', 'Request Denied. Notification Email Sent.');
                return $this->redirect(['site/admin-dashboard']);
            }
            Yii::$app->session->setFlash('errorMessages', $request->getErrors());
            return $this->redirect(['site/admin-dashboard']);
        }

        public function actionApproveRequest($id)
        {
            $request = RequestBlood::findOne($id);
            $request->approved = true;
            $request->denied = false;
            $approved_req = new Approved();
            $approved_req->request_or_donation = 'request';
            $approved_req->approved_by = Yii::$app->user->identity->name;
            $approved_req->user_id = $request->user_id;
            $approved_req->request_id = $request->id;

            if ($request->save() && $approved_req->save()) {
                Yii::$app->session->setFlash('successMessage', 'Request Approved. Notification Email Sent.');
                return $this->redirect(['site/admin-dashboard']);

            }
            Yii::$app->session->setFlash('errorMessages', $request->getErrors());
            return $this->redirect(['site/admin-dashboard']);
        }

        public function actionRejectDonation($id)
        {
            $donation = DonateBlood::findOne($id);
            $donation->reject = true;
            $rejected_donation = new Denied();
            $rejected_donation->request_or_donation = 'donation';
            $rejected_donation->denied_by = Yii::$app->user->identity->name;
            $rejected_donation->user_id = $donation->user_id;
            $rejected_donation->donate_id = $donation->id;

            if ($donation->save() && $rejected_donation->save()) {
                Yii::$app->session->setFlash('successMessage', 'Request To Donate Denied. Notification Email Sent.');
                return $this->redirect(['site/admin-dashboard']);
            }
            Yii::$app->session->setFlash('errorMessages', $donation->getErrors());
            return $this->redirect(['site/admin-dashboard']);
        }

        public function actionAcceptDonation($id)
        {
            $donation = DonateBlood::findOne($id);
            $donation->accept = true;
            $approved_donation = new Approved();
            $approved_donation->request_or_donation = 'donation';
            $approved_donation->approved_by = Yii::$app->user->identity->name;
            $approved_donation->user_id = $donation->user_id;
            $approved_donation->donate_id = $donation->id;

            if ($donation->save() && $approved_donation->save()) {
                Yii::$app->session->setFlash('successMessage', 'Request To Donate Approved. Notification Email Sent.');
                return $this->redirect(['site/admin-dashboard']);

            }
            Yii::$app->session->setFlash('errorMessages', $donation->getErrors());
            return $this->redirect(['site/admin-dashboard']);
        }

        public function actionEmail($id, $email)
        {
            $model = $this->findModel($id);
            return $this->render('_email', ['model' => $model, 'email' => $email]);

        }

        public function actionSendEmail()
        {

        }

        public function actionView($id, $table)
        {
            $model = $this->findModel($id, $table);
            return $this->renderAjax('_userItem', [
                'model' => $model,
            ]);
        }
    }
