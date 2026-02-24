<?php
/* @var $this BookController */
/* @var $model Book */

$this->pageTitle = CHtml::encode($model->title);
?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p>
		<?php echo CHtml::link('Edit', ['update', 'id' => $model->id]); ?>
		<?php echo CHtml::link(
		    'Delete',
		    ['delete', 'id' => $model->id],
		    [
		        'submit' => ['delete', 'id' => $model->id],
		        'params' => [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken],
		        'confirm' => 'Delete this book?',
		    ],
		); ?>
	</p>
<?php endif; ?>

<table class="detail-view">
	<tr>
		<th>ISBN</th>
		<td><?php echo CHtml::encode($model->isbn); ?></td>
	</tr>
	<tr>
		<th>Year</th>
		<td><?php echo (int) $model->year; ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td><?php echo CHtml::encode($model->description); ?></td>
	</tr>
	<tr>
		<th>Cover</th>
		<td>
			<?php if ($model->image_url): ?>
				<?php echo CHtml::link(CHtml::encode($model->image_url), $model->image_url, ['target' => '_blank']); ?>
			<?php else: ?>
				-
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>Authors</th>
		<td>
			<?php if (!empty($model->authors)): ?>
				<?php
		        $links = [];
			    foreach ($model->authors as $author) {
			        $links[] = CHtml::link(
			            CHtml::encode($author->last_name),
			            ['author/view', 'id' => $author->id],
			        );
			    }
			    echo implode(', ', $links);
			    ?>
			<?php else: ?>
				-
			<?php endif; ?>
		</td>
	</tr>
</table>
