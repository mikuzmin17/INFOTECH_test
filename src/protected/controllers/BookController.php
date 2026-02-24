<?php

class BookController extends Controller
{
    private $bookService;

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->bookService = new BookService();
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
        $dataProvider = new CActiveDataProvider('Book', [
            'pagination' => ['pageSize' => 10],
            'criteria' => ['order' => 'year DESC, title ASC'],
        ]);

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): void
    {
        $this->render('view', [
            'model' => $this->bookService->loadModel($id),
        ]);
    }

    public function actionCreate(): void
    {
        $model = new Book();
        $model = $this->bookService->validate($model);
        if ($model->saveWithAuthors($model->authorIds)) {
            $this->redirect(['view', 'id' => $model->id]);
        }

        $this->render('create', [
            'model' => $model,
            'authors' => $this->bookService->getAuthorsList(),
        ]);
    }

    public function actionUpdate(int $id): void
    {
        $model = $this->bookService->loadModel($id);
        $model->authorIds = CHtml::listData($model->authors, 'id', 'id');
        $model = $this->bookService->validate($model);
        if ($model->saveWithAuthors($model->authorIds)) {
            $this->redirect(['view', 'id' => $model->id]);
        }

        $this->render('update', [
            'model' => $model,
            'authors' => $this->bookService->getAuthorsList(),
        ]);
    }

    public function actionDelete(int $id): void
    {
        $this->bookService->loadModel($id)->delete();
        $this->redirect(['index']);
    }}
