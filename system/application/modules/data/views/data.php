<?php if (!empty($contents)): ?>
	<div>Total row: <?php echo $total_data?></div>

	<form class="form-group" method="post">
		<table class="table table-bordered table-striped table-condensed">
			<!-- rilis colom title -->
			<tr>
				<th>No</th>
				<?php foreach ($structure as $field): ?>
					<?php if ($field['show_on_table'] == true): ?>
						<th><?php echo $field['name'];?></th>
					<?php endif; ?>
				<?php endforeach; ?>
				<th style="width:120px">Action</th>
			</tr>

			<!-- generate filter form -->
			<tr>
				<td></td>
				<?php foreach($structure as $field): ?>	
					<?php if ($field['show_on_table'] == true): ?>
						<td><input class="form-control" type="text" name="<?php echo isset($field['relation']['relation_label'])? $field['relation']['relation_label'] : $field['field']; ?>"></td>
					<?php endif; ?>
				<?php endforeach; ?>
				<td><button class="btn btn-sm btn-default"type="submit">Filter</button></td>
			</tr>

			<!-- rilis data -->
			<?php 
			$i=($page-1)*$per_page; 
			foreach ($contents as $data): 
				$i++; 
			?>
			<tr>
				<td><?php echo $i; ?></td>

				<?php foreach ($structure as $field): ?>
					<?php if ($field['show_on_table'] == true): ?>
						<!-- if it is relation field -->
						<?php if (isset($field['relation']['relation_label'])): ?>
							<td><?php echo $data[$field['relation']['relation_label']]; ?></td>

							<!-- otherwise use field name -->
						<?php else: ?>
							<td><?php echo $data[$field['field']]; ?></td>
						<?php endif; ?>
						
					<?php endif; ?>
				<?php endforeach; ?>

				<td>
					<div class="btn-group">
						<a class="btn btn-xs btn-info" href="<?php echo $detail_url.'/'.$data['id'];?>" title="view"><span class="fa fa-search"></span></a>
						<a class="btn btn-xs btn-success" href="<?php echo $edit_url.'/'.$data['id'];?>" title="edit"><span class="fa fa-pencil"></span></a>

						<?php if ($this->fastcrud->check_ability('delete') == true): ?>
							<a class="btn btn-xs btn-warning" onclick="return confirm('Are you sure?');" href="<?php echo $delete_url.'/'.$data['id']; ?>" title="delete"><span class="fa fa-remove"></span></a>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</form>

<?php echo (isset($pagination)) ? $pagination : '';?>

<?php else:	?>
	Not found / No data
<?php endif; ?>