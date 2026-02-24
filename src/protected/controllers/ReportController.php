<?php

class ReportController extends Controller
{
    public function filters(): array
    {
        return ['accessControl'];
    }

    public function accessRules(): array
    {
        return [
            ['allow',
                'users' => ['*'],
            ],
        ];
    }

    public function actionTopAuthors(): void
    {
        $this->render('topAuthors', [
            'years' => Book::getAvailableYears(),
        ]);
    }

    public function actionTopAuthorsByYear(int $year): void
    {
        $this->render('topAuthorsByYear', [
            'year' => $year,
            'authors' => Author::getTopAuthorsByYear($year),
        ]);
    }
}
