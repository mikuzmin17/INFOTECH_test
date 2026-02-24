<?php

class AuthorController extends Controller
{
    private $authorService;

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->authorService = new AuthorService();
    }

    public function filters(): array
    {
        return [
            'accessControl',
            'postOnly + delete',
        ];
    }

    public function accessRules(): array
    {
        return [
            ['allow',
                'actions' => ['index', 'view'],
                'users' => ['*'],
            ],
            ['allow',
                'actions' => ['create', 'update', 'delete'],
                'users' => ['@'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(): void
    {
        $this->render('index', [
            'dataProvider' => new CActiveDataProvider('Author', [
                'pagination' => ['pageSize' => 10],
                'criteria' => ['order' => 'last_name ASC'],
            ]),
        ]);
    }

    public function actionView(int $id): void
    {     
        $this->render('view', [
            'model' => $this->authorService->loadModel($id),
            'subscription' => SubscriptionService::subscription($id),
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Author();

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id): void
    {
        $model = $this->authorService->loadModel($id);

        if (isset($_POST['Author'])) {
            $model->attributes = $_POST['Author'];
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id): void
    {
        $this->authorService->loadModel($id)->delete();
        $this->redirect(['index']);
    }
}
