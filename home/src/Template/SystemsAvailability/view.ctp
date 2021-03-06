<!-- File: src/Template/SystemsAvailability/view.ctp -->
<?php date_default_timezone_set('Europe/London'); ?>

<div class="row">

  <h3><?= $view->name ?></h3>

	<div class="waf-include">

        <?php if (!empty($systems) && count($systems)>0) { ?>

				<table class="waf-systems-availability view-<?= $view->id ?>">
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
							<tr class="system-<?= $system->id ?>">
								<td>
								  <?php if (!empty($system->url)) echo '<a href="'.$system->url.'">'; ?>
								  <?= $system->name ?>
								  <?php if (!empty($system->url)) echo '</a>'; ?>
								</td>
								<td class="<?= $system->level ?>"><strong><?= $system->levelName ?></strong>
								  <div class="indicators">
										<span class="indicator indicator-red"></span>
										<span class="indicator indicator-amber"></span>
										<span class="indicator indicator-green"></span>
								  </div>								</td>
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
