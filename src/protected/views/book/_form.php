<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $authors array */

$form = $this->beginWidget('CActiveForm', [
    'id' => 'book-form',
    'enableAjaxValidation' => false,
]);
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model, 'isbn'); ?>
	<?php echo $form->textField($model, 'isbn'); ?>
	<?php echo $form->error($model, 'isbn'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'title'); ?>
	<?php echo $form->textField($model, 'title'); ?>
	<?php echo $form->error($model, 'title'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'year'); ?>
	<?php echo $form->textField($model, 'year'); ?>
	<?php echo $form->error($model, 'year'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'image_url'); ?>
	<?php echo $form->textField($model, 'image_url'); ?>
	<?php echo $form->error($model, 'image_url'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'description'); ?>
	<?php echo $form->textArea($model, 'description', ['rows' => 5]); ?>
	<?php echo $form->error($model, 'description'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'authorIds'); ?>
	<?php echo CHtml::activeListBox(
	    $model,
	    'authorIds',
	    $authors,
	    ['multiple' => 'multiple', 'size' => 6],
	); ?>
	<?php echo $form->error($model, 'authorIds'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>
