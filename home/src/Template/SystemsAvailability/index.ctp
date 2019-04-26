<!-- File: src/Template/SystemsAvailability/index.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Systems Availability Views.</h3>

		<?php if (!empty($views) && count($views)>0) { ?>

			<ul>
			<?php foreach ($views as $view): ?>
				<li>
				  <?= $this->Html->link($view->name, ['action' => 'view', $view->id]) ?>
				  (<?= $this->Html->link('cols', ['action' => 'cols', $view->id]) ?>)
				</li>
			<?php endforeach; ?>
			</ul>

		<?php } else { ?>
			<p><em>No views found</em></p>
		<?php } ?>

	</div>
</div>
