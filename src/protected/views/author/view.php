<?php
/* @var $this AuthorController */
/* @var $model Author */
/* @var $subscription Subscription */

$this->pageTitle = CHtml::encode($model->last_name);
?>

<h1><?php echo CHtml::encode($model->last_name); ?></h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p>
		<?php echo CHtml::link('Edit', ['update', 'id' => $model->id]); ?>
		<?php echo CHtml::link(
		    'Delete',
		    ['delete', 'id' => $model->id],
		    [
		        'submit' => ['delete', 'id' => $model->id],
		        'params' => [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken],
		        'confirm' => 'Delete this author?',
		    ],
		); ?>
	</p>
<?php endif; ?>

<h3>Author Books</h3>

<?php if (!empty($model->books)): ?>
	<ul>
		<?php foreach ($model->books as $book): ?>
			<li>
				<?php echo CHtml::link(
				    CHtml::encode($book->title),
				    ['book/view', 'id' => $book->id],
				); ?>
				<?php if ($book->year): ?>
					(<?php echo (int) $book->year; ?>)
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p>No books found.</p>
<?php endif; ?>

<?php if (Yii::app()->user->isGuest): ?>
	<h3>Author Subscription</h3>

	<?php if (Yii::app()->user->hasFlash('success')): ?>
		<p class="success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
	<?php endif; ?>

	<?php
    $form = $this->beginWidget('CActiveForm', [
        'id' => 'subscription-form',
        'enableAjaxValidation' => false,
    ]);
    ?>

	<div class="row">
		<?php echo $form->labelEx($subscription, 'phone'); ?>
		<?php echo $form->textField($subscription, 'phone'); ?>
		<?php echo $form->error($subscription, 'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Subscribe'); ?>
	</div>

	<?php $this->endWidget(); ?>
<?php endif; ?>
