<?php
/* @var $this AuthorController */
/* @var $model Author */

$form = $this->beginWidget('CActiveForm', [
    'id' => 'author-form',
    'enableAjaxValidation' => false,
]);
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model, 'last_name'); ?>
	<?php echo $form->textField($model, 'last_name'); ?>
	<?php echo $form->error($model, 'last_name'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>
