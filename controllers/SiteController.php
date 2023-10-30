<?php

    namespace app\controllers;

    use app\models\ContactForm;
    use app\models\DonateBlood;
    use app\models\RequestBlood;
    use app\models\User;
    use Yii;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Url;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\Response;

    class SiteController extends Controller
    {

        /**
         * {@inheritdoc}
         */
        public function behaviors()
        {

            return ['access' => ['class' => AccessControl::class, 'only' => ['logout'], 'rules' => [['actions' => ['logout'], 'allow' => true, 'roles' => ['@'],],],],
                'verbs' => ['class' => VerbFilter::class, 'actions' => ['logout' => ['post'],],],

            ];
        }

        /**
         * {@inheritdoc}
         */
        public function actions()
        {

            return ['error' => ['class' => 'yii\web\ErrorAction',], 'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,],];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex()
        {

            return $this->render('index');
        }

        /**
         * Login action.
         *
         * @return Response|string
         */
        public function actionLogin()
        {
            if (!Yii::$app->user->isGuest) {
                // User is already logged in, redirect to the appropriate dashboard
                return $this->redirect(Yii::$app->user->identity->getDashboardUrl());
            }

            $user = new User(['scenario' => User::SCENARIO_LOGIN]);
            $request = Yii::$app->request->post();

            if ($user->load($request) && $user->login()) {
                // Login successful, redirect to the appropriate dashboard
                return $this->redirect(Yii::$app->user->identity->getDashboardUrl());
            }

            // Clear the password attribute of the user so that it's not retained in memory
            $user->password = '';

            return $this->render('login', ['user' => $user,]);

        }

        /**
         * Logout action.
         *
         * @return Response
         */
        public function actionLogout()
        {

            Yii::$app->user->logout();
            Yii::$app->session->destroy();
            return $this->goHome();
        }

        /**
         * Displays contact page.
         *
         * @return Response|string
         */
        public function actionContact()
        {

            $model = new ContactForm();
            if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }
            return $this->render('contact', ['model' => $model,]);
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
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);//Hash password before sending to db
            $session = Yii::$app->session;
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');

            if ($user->validate() && $user->save()) {
                $auth->assign($role, $user->getId());
                $session->setFlash('successMessage', 'Your Account has been created.');
                return $this->redirect(['site/login']);

            }

            $session->setFlash('errorMessages', $user->getErrors());
            return $this->redirect(['site/register']);
        }

        public function actionUpdate($id)
        {
            $session = Yii::$app->session;
            $model = $this->findModel($id);
            $model->updated_at = date('Y-m-d H:i:s');

            if (Yii::$app->request->isGet) {
                Url::remember($this->request->referrer, $this->action->uniqueId);
            }

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $session->setFlash('successMessage', 'record has been successfully updated');
                return $this->redirect(
                    Url::previous($this->action->uniqueId) ?: ['view', 'id' => $model->id]
                );
//                return $this->redirect(['view', 'id' => $model->id]);
            }
            $session->setFlash('errorMessages', $model->getErrors());
            return $this->render('userUpdate', [
                'model' => $model,
            ]);
        }

        protected function findModel($id)
        {
            if (($model = User::findOne(['id' => $id])) !== null) {
                return $model;
            } elseif (($model = RequestBlood::findOne(['id' => $id])) !== null) {
                return $model;
            } elseif (($model = DonateBlood::findOne(['id' => $id])) !== null) {
                return $model;

            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
