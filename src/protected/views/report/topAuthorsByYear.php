<?php
/* @var $this ReportController */
/* @var $year int */
/* @var $authors array */

$this->pageTitle = 'Top Authors for ' . (int) $year;
?>

<h1>Top-10 Authors for <?php echo (int) $year; ?></h1>

<?php if (empty($authors)): ?>
	<p>No data available.</p>
<?php else: ?>
	<table class="detail-view">
		<thead>
			<tr>
				<th>#</th>
				<th>Author</th>
				<th>Books</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($authors as $index => $author): ?>
				<tr>
					<td><?php echo (int) ($index + 1); ?></td>
					<td><?php echo CHtml::encode($author['last_name']); ?></td>>
					<td><?php echo (int) $author['books_count']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
