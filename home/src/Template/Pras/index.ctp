<!-- File: src/Template/Pras/index.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras, [ 'novalidate' => true ]);
		?>

		<h4>Scope</h4>
		<p>Select the type of change</p>
		<?= $this->Form->input('stage', ['type' => 'hidden', 'value' => 1 ]); ?>
		<?= $this->Form->control('changeType', ['type' => 'radio', 'options' => $pras->changeTypeOptions(), 'label' => 'Change Type', 'templates'=>$waf->template_wrappers('generalPurposesConfirmed', '', 'spaced') ]); ?>

		<p>Select the affected organisation</p>
		<p id="newdivision" class="notes">
		  If creating a new entity select the parent entity, or
		  <?= $this->Form->button('Create a new Division', [ 'name'=>'entityType', 'value'=>'level1' ]); ?>
		</p>
		<ul id="pras-select-menu" class="waf-menu-select">
		<?php foreach ($pras->getHierarchyArray() as $d_key => $division) { ?>

			<li>
				<?= $this->Form->button($division['name'], [ 'name'=>'entity', 'value'=>$d_key ]); ?>
				<?php if (!empty($division['units'])) : ?>
					<ul>
					<?php foreach ($division['units'] as $u_key => $unit) { ?>

						<li>
							<?= $this->Form->button($unit['full'], [ 'name'=>'entity', 'value'=>$d_key.'|'.$u_key ]); ?>
							<?php if (!empty($unit['subunits'])) : ?>
								<ul>
								<?php foreach ($unit['subunits'] as $s_key => $subunit) { ?>

									<li>
										<?= $this->Form->button($subunit['full'], [ 'name'=>'entity', 'value'=>$d_key.'|'.$u_key.'|'.$s_key ]); ?>
										<?php if (!empty($subunit['ccs'])) : ?>
											<ul>
											<?php foreach ($subunit['ccs'] as $c_key => $cc) { ?>
												<li>
													<?= $this->Form->button($cc['name'], [ 'name'=>'entity', 'value'=>$d_key.'|'.$u_key.'|'.$s_key.'|'.$c_key ]); ?>
												</li>
											<?php } ?>
											</ul>
										<?php endif; ?>
									</li>

								<?php } ?>
								</ul>
							<?php endif; ?>
						</li>

					<?php } ?>
					</ul>
				<?php endif; ?>
			</li>

		<?php } ?>
		</ul>

		<?=	$this->Form->end(); ?>

    <?php // echo '<textarea rows="50" style="line-height:1.2em;font-size:11px">' . print_r($pras->getHierarchyArray(),true) . '</textarea>' ?>

	</div>
</div>
