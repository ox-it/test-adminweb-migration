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
				<?php if ( !empty($_GET['rejects']) ) : ?>
					<p><strong>There are currently no rejected applications matching that search</strong></p>
				<?php else : ?>
					<p><strong>There are currently no rejected applications</strong></p>
				<?php endif; ?>
			<?php else : ?>

				<!-- Submit -->
				<?php
					echo $this->Form->button(__('Accept Selected'), [ 'name'=>'accept', 'class'=>'btn button btn-primary' ]);
					echo $waf->postButtonToReferer($this, 'Return to Admin Form', true);
				?>

				<p>
					The following people below have been rejected. This list is limited to 100 entries,
					but you can narrow the search by selecting a letter of the alphabet below
					to list only applicants with surnames starting with that letter.
				</p>
				<p>
					You can accept individuals by selecting their checkbox and clicking on 'Accept Selected'.
				</p>
				<p>
				  <?php
				    $letters = str_split('abcdefghijklmnopqrstuvwxyz');
				    foreach ($letters as $l) {
				      echo '<a href="?rejects='.$l.'">'.strtoupper($l).'</a> | ';
				    }
				    echo '<a href="?rejects">All</a>';
				  ?>
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
							<?= $this->Form->control('selector'.$applicant->applicantID, [ 'type'=>'checkbox', 'label'=>false ]) ?>
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
				echo $this->Form->button(__('Accept Selected'), [ 'name'=>'accept', 'class'=>'btn button btn-primary' ]);
        echo $waf->postButtonToReferer($this, 'Return to Admin Form');
			?>

		  <?php
				echo $this->Form->end();
		  ?>

	</div>
</div>