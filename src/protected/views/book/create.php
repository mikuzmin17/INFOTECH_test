<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $authors array */

$this->pageTitle = 'Create Book';
?>

<h1>Create Book</h1>

<?php echo $this->renderPartial('_form', ['model' => $model, 'authors' => $authors]); ?>
