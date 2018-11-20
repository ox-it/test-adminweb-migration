<!-- File: src/Template/Gcp/index.ctp -->

<div class="row">

	<h3>
		GCP Online Application Admin
	</h3>

  <?php //echo '<p>Found '.count($applicants).':</p>'; echo '<textarea rows="10" style="line-height:1.1em">' . print_r($applicants, true) . '</textarea>'; ?>

	<div class="waf-include">

    <!-- Form -->
		<?= $this->Form->create($admin, [ 'context'=>[ 'validator'=>'admin' ], 'novalidate' => true ]) ?>

			<?= $this->Form->control('row_tot', [ 'type'=>'hidden', 'value'=>count($applicants) ]) ?>

			<?php if (count($applicants)==0) : ?>
			  <p>
			    <strong>There are currently no Pending Applications</strong>
			  </p>
			<?php else : ?>
				<p>
					The people below have registered for the on-line course.
				</p>
				<p>
				  You can also see the
				  <a href="?accepted=">Accepted Applications</a>, or see the
				  <a href="?rejects=">Rejected Applications</a>.
				</p>

				<hr />
				<?php foreach ($applicants as $i=>$applicant) { ?>
					<?php
						if ($applicant['employer'] == "U") $employer = "University of Oxford";
						else if ($applicant['employer'] == "R") $employer = "Oxford Radcliffe Hospitals";
						else $employer = "Other Employer";
					?>
					<div class="applicant column_wrapper">
						<div class="control" style="flex-grow:0;text-align:center">
							<?= $this->Form->control('app'.$i, [ 'type'=>'hidden', 'value'=>$applicant->applicantID ]) ?>
							<?= $this->Form->control('selector'.$applicant->applicantID, [ 'type'=>'checkbox', 'label'=>'' ]) ?>
						</div>
						<div class="info">
							<p>
							  <strong><?= $applicant->title ?> <?= $applicant->forename ?> <?= $applicant->surname ?></strong> &nbsp;
							  (<a href="mailto:<?= $applicant->email ?>"><?= $applicant->email ?></a>) &nbsp;
                <?= date('d/m/y', $applicant['made_stamp']) ?>
              </p>
              <p>
                <u><?= $applicant->position ?></u> &nbsp;
                (<?= $employer ?>)
              </p>
              <p>
                <em>Research role:</em> &nbsp;<?= $applicant->role ?>
								<?php if (!empty($applicant->additional)) : ?><br>
									<em>Additional information:</em> &nbsp;<?= $applicant->additional ?>
								<?php endif; ?>
								<?php if (!empty($applicant->study)) : ?><br>
									<em>Study:</em> &nbsp;<?= $applicant->study ?> &nbsp; &nbsp;
									<em>Investigator:</em> &nbsp;<?= $applicant->investigator ?> &nbsp; &nbsp;
									<em>REC:</em> &nbsp;<?= $applicant->REC ?> &nbsp; &nbsp;
									<em>Project ID:</em> &nbsp;<?= $applicant->project ?>
								<?php endif; ?>
              </p>
						</div>
					</div>
					<hr />
				<?php } ?>

			<?php endif; ?>


			<!-- Submit -->
			<?php
				echo $this->Form->button(__('Accept'), [ 'name'=>'accept', 'class'=>'btn button btn-primary' ]);
				echo $this->Form->button(__('Reject'), [ 'name'=>'reject', 'class'=>'btn button btn-primary' ]);
			?>

		  <?php
				echo $this->Form->end();
		  ?>

	</div>
</div>