<!-- File: src/Template/Jobs/index.ctp -->

<div class="row">

	<div class="waf-include">

	  <div id="job-vacancies-app">

    <hr>
    <?php foreach ($feed['currentVacancies']['vacancy'] as $vacancy) { ?>

      <?php $grade = explode(':', $vacancy['gradeAndSalaryText']); ?>

			<h2 style="margin: 1em 0 0 3px; ">
			<?= $vacancy['shortDescription'] ?>
			</h2>
			<table class="table"><tbody>
				<tr><td colspan="4" style="width: 100%;" class="orgGroupLocationText"><strong>
				<?= $vacancy['orgGroupLocationText'] ?>
				</strong></td></tr>
				<tr>
					<td style="width: 20%;">Vacancy type: </td>
					<td colspan="3" class="competitionType">
					<?= $vacancy['competitionType']['description'] ?>
					</td>
				</tr>
				<tr>
					<td class="gradeAndSalaryText">
					<?= count($grade)>1 ? $grade[0] : 'Pay' ?>:</td>
					<td colspan="3" class="gradeAndSalaryText"><?= count($grade)==1 ? $grade[0] : $grade[1] ?>
					</td>
				</tr>
				<tr>
					<td>Vacancy ID :</td>
					<td style="width: 30%;" class="recruitmentId">
					<?= $vacancy['recruitmentId'] ?>
					</td>
					<td style="width: 20%;" class="job-closing">Closing Date :</td>
					<td style="width: 30%;" class="recruitmentClosesDate">
					<?= $vacancy['recruitmentClosesDate'] ?>
					</td>
				</tr>
				<tr>
					<td style="width: 20%;">
						Contact Name:
					</td>
					<td style="width: 30%;">
						<?= $vacancy['contactPersonText'] ?>
					</td>
					<td style="width: 20%;">
						Contact Email:
					</td>
					<td style="width: 30%;">
					  <?php if (!empty($vacancy['contactEmailText'])) : ?>
						<a href="mailto:<?= $vacancy['contactEmailText'] ?>"><?= $vacancy['contactEmailText'] ?></a>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="width: 100%;" class="jobDescription">
					  <?= $vacancy['jobDescription'] ?>
					</td>
				</tr>
			</tbody></table>
			<hr>

    <?php } ?>

		<?php //print '<textarea rows="5" style="line-height:1.2em;font-size:11px">' . print_r($feed,true) . '</textarea>'; ?>
		<?php //print '<textarea rows="5" style="line-height:1.2em;font-size:11px">' . print_r($file,true) . '</textarea>'; ?>

	  </div>
	</div>
</div>
