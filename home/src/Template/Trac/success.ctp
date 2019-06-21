<!-- File: src/Template/Trac/green.ctp -->

<div class="row">

  <h3>University of Oxford - Academic Activity Survey Submission</h3>

	<?= $this->Html->script($this->name . '/script.js') ?>

	<div class="waf-include">
  <div class="<?= $survey->group_colour ?>">

	  <!-- Information -->
	  <h2>SUBMISSION CONFIRMATION</h2>
    <div align="right"><strong>Week ref. <?= $survey->weekly_group ?> - <?= strtoupper($survey->group_colour) ?> form</strong></div>
    <p>Data Collection Week Commencing: Monday <?= $survey->group_week ?>.</p>
    <p>Your data has been updated! (Submission date: <?= date('jS F Y', $survey->old_date) ?>)</p>
    <p>The table below shows your latest data. Please print a copy for your records.</p>
    <p>
      You may, at any time during the current collection period
      (<?= $survey->group_week ?> - <?= $survey->group_finish_date ?>),
      amend your data by returning to this page.
    </p>
    <p>
      <strong>No entries or amendments will be accepted after collection closes on <?= $survey->group_finish_date ?>.</strong>
    </p>

		<hr class="line" />

		<?= $waf->postValueWithLabel($survey->title, 'Title') ?>
		<?= $waf->postValueWithLabel($survey->initials, 'Initials') ?>
		<?= $waf->postValueWithLabel(ucwords($survey->surname), 'Surname') ?>
		<?= $waf->postValueWithLabel($survey->payroll, 'Employee/Payroll Number') ?>
		<?= $waf->postValueWithLabel($survey->department, 'Department/Faculty') ?>

		<?php if (!empty($survey->gender) || (!empty($survey->pftw) && $survey->pftw!=0)) : ?>
			<hr class="line" />
			<?= $waf->postValueWithLabel($survey->gender, 'Gender', $survey->genderOptions()) ?>
			<?= $waf->postValueWithLabelIfNotZero($survey->pftw, 'Percentage of full time worked') ?>
		<?php endif; ?>

		<hr class="line" />
		<h3>ABSENCE</h3>
		<?php if ($survey->absent=='y') : ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xsic_h, 'Sick Leave') ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xhol_h, 'Vacation/Holiday') ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xsab_h, 'Sabbatical (Divided: 86% to B1.1, 5% to A03 and 9% to C6)') ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xmat_h, 'Maternity/Paternity Leave') ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xoth_h, 'Other') ?>
			<?= $survey->postDaysHoursPercWithLabel($survey->xsic_h + $survey->xhol_h + $survey->xsab_h + $survey->xmat_h + $survey->xoth_h, 'Total Absence') ?>
		<?php else : ?>
		  <p>No reported absences</p>
			<hr class="line" />
		<?php endif; ?>

		<p>&nbsp;</p>
		<h3>A. TEACHING (by teaching method)<sup>*</sup></h3>

		<h4>Undergraduate Teaching</h4>
		<?= $waf->postHeadersWithLabel(['Direct Contact Hours','Preparation &amp; Assessment','Hours Worked','% of Total'],'&nbsp;') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a01', 'A01: Lectures (including demonstrations in lectures)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a02', 'A02: Tutorials') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a43', 'A43: Seminars and classes (department/faculty)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a53', 'A53: Seminars and classes (college)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a04', 'A04: Laboratory practicals and other laboratory teaching') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a07', 'A07: Other teaching including fieldwork and supervision of project work') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('a48', 'A48: Assessment, examining, admissions, student welfare and other support for UG teaching (dept/faculty)') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('a58', 'A58: Assessment, examining, admissions, student welfare and other support for UG teaching (college)') ?>
		<hr class="line" />

		<h4>Postgraduate Teaching</h4>
		<?= $waf->postHeadersWithLabel(['Direct Contact Hours','Preparation &amp; Assessment','Hours Worked','% of Total'],'&nbsp;') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a21', 'A21: Lectures (including demonstrations in lectures)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a22', 'A22: Tutorials') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a63', 'A63: Seminars and classes (department/faculty)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a73', 'A73: Seminars and classes (college)') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a24', 'A24: Laboratory practicals and other laboratory teaching') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a27', 'A27: Other teaching including fieldwork and supervision of project work') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('a68', 'A68: Assessment, examining, admissions, student welfare and other support for PG teaching (dept/faculty)') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('a78', 'A78: Assessment, examining, admissions, student welfare and other support for PG teaching (college)') ?>
		<hr class="line" />

		<h4>Postgraduate Researchers Teaching</h4>
		<?= $waf->postValueWithLabel($survey->a_pgr, 'Number of PGR students you are currently supervising and co-supervising, (0.5 for co-supervised students)') ?>
		<?= $waf->postHeadersWithLabel(['Direct Contact Hours','Preparation &amp; Assessment','Hours Worked','% of Total'],'&nbsp;') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('b17', 'B17: Supervision of PGR students') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a33', 'A33: Lectures, seminars and classes for PGR students') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('b88', 'B88: Assessment, examining, admissions, student welfare and other support for PGR teaching (dept/faculty)') ?>
		<?= $survey->postPrepHoursPercentageWithLabel('b98', 'B98 Assessment, examining, admissions, student welfare and other support for PGR teaching (college)') ?>
		<hr class="line" />

		<h4>Special Courses</h4>
		<?= $waf->postHeadersWithLabel(['Direct Contact Hours','Preparation &amp; Assessment','Hours Worked','% of Total'],'&nbsp;') ?>
		<?= $survey->postContactPrepHoursPercentageWithLabel('a08', 'A08: Short courses, non-matriculated award and non-award-bearing and summer course') ?>

		<h4>Total</h4>
		<?= $survey->postContactPrepHoursPercentageWithLabel('abt', 'Teaching Total', true) ?>


		<p>&nbsp;</p>
		<h3>B. RESEARCH (by teaching method)<sup>*</sup></h3>

		<h4>Publicly Funded Research</h4>
		<?= $survey->postHoursPercentageWithLabel('b11', 'B1.1: University research where there is no external sponsor') ?>
		<?= $survey->postHoursPercentageWithLabel('b12', 'B1.2: Research Councils') ?>
		<?= $survey->postHoursPercentageWithLabel('b13', 'B1.3: UK Government bodies (inc. Local Authorities, Health Authorities etc.)') ?>
		<?= $survey->postHoursPercentageWithLabel('b14', 'B1.4: European Commission; European Social Fund') ?>
		<?= $survey->postHoursPercentageWithLabel('b1t', 'Total direct time spent on Publicly Funded Research', true) ?>

		<h4>Non-Publicly Funded Research</h4>
		<?= $survey->postHoursPercentageWithLabel('b21', 'B2.1: College funded research (Not CUF)') ?>
		<?= $survey->postHoursPercentageWithLabel('b22', 'B2.2: UK-based charities') ?>
		<?= $survey->postHoursPercentageWithLabel('b23', 'B2.3: UK industry, commerce and public corporations') ?>
		<?= $survey->postHoursPercentageWithLabel('b24', 'B2.4: Other sources (UK)') ?>
		<?= $survey->postHoursPercentageWithLabel('b25', 'B2.5: EU countries (all sources other than European Commission)') ?>
		<?= $survey->postHoursPercentageWithLabel('b26', 'B2.6: Other overseas (all sources)') ?>
		<?= $survey->postHoursPercentageWithLabel('b2t', 'Total direct time spent on Non-Publicly Funded Research', true) ?>

		<h4>Research Support</h4>
		<?= $survey->postHoursPercentageWithLabel('b31', 'B3.1: Total time spent on support for research') ?>

		<h4>Total</h4>
		<?= $survey->postHoursPercentageWithLabel('bt', 'Total time spent on Research', true) ?>


		<p>&nbsp;</p>
		<h3>C. OTHER ACTIVITIES<sup>*</sup></h3>
		<?= $survey->postHoursPercentageWithLabel('c1', 'C1: Clinical duties performed (NHS Knock for Knock)') ?>
		<?= $survey->postHoursPercentageWithLabel('c1a', 'C1a: Clinical duties performed (Overseas)') ?>
		<?= $survey->postHoursPercentageWithLabel('c2', 'C2: Non-Research Clinical Trials') ?>
		<?= $survey->postHoursPercentageWithLabel('c3', 'C3: Services for the General Public') ?>
		<?= $survey->postHoursPercentageWithLabel('c4', 'C4: Other professional work') ?>
		<?= $survey->postHoursPercentageWithLabel('c5', 'C5: Public Service (e.g. Jury Service, School Governors, Magistrates etc.)') ?>
		<?= $survey->postHoursPercentageWithLabel('c6', 'C6: Support for above activities') ?>
		<?= $survey->postHoursPercentageWithLabel('ct', 'Total spent on Other Activities', true) ?>


		<p>&nbsp;</p>
		<h3>D. GENERAL SUPPORT<sup>*</sup></h3>
		<?= $survey->postHoursPercentageWithLabel('d11', 'D1.1: University/faculty/department administration and committee work') ?>
		<?= $survey->postHoursPercentageWithLabel('d12', 'D1.2: Continuing Professional Development and Training') ?>
		<?= $survey->postHoursPercentageWithLabel('d21', 'D2.1: College administration &amp; Committee work') ?>
		<?= $survey->postHoursPercentageWithLabel('d13', 'D1.3: Other general support') ?>
		<?= $survey->postHoursPercentageWithLabel('dt', 'Total spent on General Support', true) ?>


		<p>&nbsp;</p>
		<h3>OVERALL TOTAL FOR PERIOD</h3>
		<?= $survey->postHoursPercentageWithLabel('tt', '', true) ?>


		<!-- Return Link -->
		<p>&nbsp;</p>
		<?= $waf->postButtonToReferer($this, 'Return to TRAC Form') ?>

	</div>
	</div>
</div>