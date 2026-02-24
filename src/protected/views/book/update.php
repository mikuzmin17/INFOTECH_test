<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $authors array */

$this->pageTitle = 'Update Book';
?>

<h1>Update Book</h1>

<?php echo $this->renderPartial('_form', ['model' => $model, 'authors' => $authors]); ?>
