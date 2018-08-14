<!-- File: src/Template/SystemsAvailability/view.ctp -->

<div class="row">
	<div class="waf-include">

        <h3><?= $view->name ?></h3>

        <?php if (!empty($systems) && count($systems)>0) { ?>

				<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Level</th>
							<th>Status</th>
							<th>Details</th>
							<th>Updated</th>
						</tr>
					</thead>
					<tbody>
  					<?php foreach ($systems as $system): ?>
							<tr>
								<td>
								  <?php if (!empty($system->url)) echo '<a href="'.$system->url.'">'; ?>
								  <?= $system->name ?>
								  <?php if (!empty($system->url)) echo '</a>'; ?>
								</td>
								<td class="<?= $system->level ?>"><strong><?= $system->levelName ?></strong></td>
								<td><?= $system->text ?></td>
								<td><?= $system->details ?></td>
								<td><?= date('j M Y, H:i', $system->time) ?></td>
							</tr>
  					<?php endforeach; ?>
					</tbody>
				</table>

				<?php //echo '<textarea>' . print_r($systems, true) . '</textarea>'; ?>

        <?php } else { ?>

          <p><em>No systems found</em></p>

        <?php } ?>

	</div>
</div>
