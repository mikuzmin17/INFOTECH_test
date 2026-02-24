<?php
/* @var $this BookController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Books';
?>

<h1>Books</h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p><?php echo CHtml::link('Create Book', ['create']); ?></p>
<?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'dataProvider' => $dataProvider,
    'columns' => [
        'title',
        'year',
        'isbn',
        [
            'name' => 'image_url',
            'type' => 'raw',
            'value' => '($data->image_url) ? CHtml::link(CHtml::encode($data->image_url), $data->image_url, array("target" => "_blank")) : "N/A"',
        ],
        [
            'class' => 'CButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'update' => ['visible' => '!Yii::app()->user->isGuest'],
                'delete' => ['visible' => '!Yii::app()->user->isGuest'],
            ],
        ],
    ],
]); ?>
