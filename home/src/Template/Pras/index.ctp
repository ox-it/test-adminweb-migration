<!-- File: src/Template/Pras/index.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Change Organisational Structure</h3>

		<p>If you are experiencing difficulties accessing this form please email PRAS at <a href="mailto:orgstructure@admin.ox.ac.uk">orgstructure@admin.ox.ac.uk</a>.</p>

		<!-- Form -->
		<?php
			echo $this->Form->create($pras, ['type'=>'get']);
		?>

		<h4>Scope</h4>
		<p>Select the scope of the proposed change.</p>
		<?= $this->Form->input('changeType', ['type' => 'radio', 'options' => $change_type_options, 'label' => 'Change Type']); ?>

    <ul id="pras-select-menu" class="waf-menu-select">
    <?php foreach ($hierarchy as $d_key => $division) { ?>

      <li>
        <button value="<?= $d_key ?>" name="entity" type="submit"><?= $division['name'] ?></button>
				<?php if (!empty($division['units'])) : ?>
					<ul>
					<?php foreach ($division['units'] as $u_key => $unit) { ?>

						<li>
							<button value="<?= $d_key.'|'.$u_key ?>" name="entity" type="submit"><?= $unit['full'] ?></button>
							<?php if (!empty($unit['subunits'])) : ?>
								<ul>
								<?php foreach ($unit['subunits'] as $s_key => $subunit) { ?>

									<li>
										<button value="<?= $d_key.'|'.$u_key.'|'.$s_key ?>" name="entity" type="submit"><?= $subunit['full'] ?></button>
										<?php if (!empty($subunit['ccs'])) : ?>
											<ul>
											<?php foreach ($subunit['ccs'] as $c_key => $cc) { ?>
												<li><button value="<?= $d_key.'|'.$u_key.'|'.$s_key.'|'.$c_key ?>" name="entity" type="submit"><?= $cc['name'] ?></button></li>
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

    <?= $this->Form->button('Change'); ?>
		<?=	$this->Form->end(); ?>

    <?php echo '<textarea rows="50" style="line-height:1.2em;font-size:11px">' . print_r($hierarchy,true) . '</textarea>' ?>

	</div>
</div>
