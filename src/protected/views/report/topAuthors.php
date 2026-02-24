<?php
/* @var $this ReportController */
/* @var $years array */

$this->pageTitle = 'Top Authors by Year';
?>

<h1>Top Authors by Year</h1>

<?php if (empty($years)): ?>
	<p>No data available.</p>
<?php else: ?>
	<ul>
		<?php foreach ($years as $year): ?>
			<li>
				<?php echo CHtml::link(
				    CHtml::encode($year),
				    ['report/topAuthorsByYear', 'year' => $year],
				); ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
