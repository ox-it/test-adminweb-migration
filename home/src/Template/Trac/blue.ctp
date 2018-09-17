<!-- File: src/Template/Trac/blue.ctp -->

<div class="row">

  <h3>University of Oxford - Academic Activity Survey :  BLUE</h3>

	<?= $this->Html->script($this->name . '/script.js') ?>

	<div class="waf-include">
  <div class="<?= $survey->group_colour ?>">

	  <!-- Information -->
    <div align="right"><strong>Week ref. <?= $survey->weekly_group ?> - <?= strtoupper($survey->group_colour) ?> form</strong></div>
    <p>
      Data Collection Week Commencing: Monday <?= $survey->group_week ?>.<br />
      <strong>NOTE:</strong> Collection closes on <?= $survey->group_finish_date ?>.
      No entries or amendments will be accepted after this date.
    </p>

    <!-- Form : Contains a form which academics can fill to indicate how much of their working time is spent on differing activities.
      This survey is the University of Oxford Academic Activity Survey. -->
		<?= $this->Form->create($survey, [ 'context'=>[ 'validator'=>'green' ], 'novalidate' => true ]) ?>

			<?= $waf->postValueWithLabel($survey->title, 'Title') ?>
			<?= $waf->postValueWithLabel($survey->initials, 'Initials') ?>
			<?= $waf->postValueWithLabel(ucwords($survey->surname), 'Surname') ?>
			<?= $waf->postValueWithLabel($survey->payroll, 'Employee/Payroll Number') ?>
			<?= $waf->postValueWithLabel($survey->department, 'Department/Faculty') ?>
			<p>
				(If any of the above information is incorrect please contact
				<a href="mailto:payroll@admin.ox.ac.uk">payroll</a>.)
			</p>

			<hr class="line" />
			<?= $this->Form->input('gender', [ 'type'=>'radio', 'label'=>'Gender', 'options'=>$survey->genderOptions(), 'class'=>'with-notes', 'templates'=>$waf->template_wrappers('gender','') ]) ?>
			<?= $this->Form->input('pftw', [ 'label'=>'If employed part-time, please give percentage of full time worked', 'size'=>4, 'maxlength'=>3, 'align'=>'right', 'templates'=>$waf->template_wrappers('pftw','<span class="notes">%</span>',['inline_wrapper']) ]) ?>

			<hr class="line" />

      <h3>ABSENCE</h3>
			<?= $this->Form->input('absent', [ 'type'=>'checkbox', 'label'=>'Please tick here if you were absent for all or part of the chosen week', 'value'=>'y', 'hiddenField'=>'-', 'templates'=>$waf->template_wrappers('absent') ]) ?>
			<div id="absence">
				<p><strong>Please provide details:</strong></p>
        <p><strong>Note:</strong> The totals and percentages on this page will not be displayed if your browser does not have JavaScript enabled.)</p>
				<?= $survey::daysHoursPercentageInput($this, 'xsic', 'Sick Leave') ?>
				<?= $survey::daysHoursPercentageInput($this, 'xhol', 'Vacation/Holiday') ?>
				<?= $survey::daysHoursPercentageInput($this, 'xsab', 'Sabbatical (Divided: 86% to B1.1, 5% to A03 and 9% to C6)') ?>
				<?= $survey::daysHoursPercentageInput($this, 'xmat', 'Maternity/Paternity Leave') ?>
				<?= $survey::daysHoursPercentageInput($this, 'xoth', 'Other - please email your reason for absence to <a href="mailto:aas@admin.ox.ac.uk">aas@admin.ox.ac.uk</a>') ?>
				<?= $survey::daysHoursPercentageInput($this, 'xt', 'Total Absence', true) ?>
      </div>

      <p>&nbsp;</p>
			<h3>A. TEACHING (by teaching method)<sup>*</sup></h3>
      <div id="note1" class="waf-expandable">
        <p>
          <strong>Teaching for UGs, PGTs and PGRs</strong><br />
          Teaching data is collected by type of student (UG, PGT, PGR) and by type of teaching (lectures, tutorials etc.).
          For each type of teaching, there is a box for "contact hours" and one for "preparation".
          Brief notes are provided where the intention of the form may not be entirely clear.
          Please do not hesitate to contact the AAS team <strong>[<a href="mailto:AAS@admin.ox.ac.uk">AAS@admin.ox.ac.uk</a>]</strong> if you need further information or support.
        </p>
				<p>
				  <strong>Contact hours</strong><br />
					Contact hours are defined as time spent on teaching undergraduates and postgraduate students both within your own and other departments, faculties and colleges or other parts of the collegiate University.
					Contact hours are further categorised into lectures, tutorials, department classes, college classes, practicals and other types of teaching.
					It is recognised that not all teaching will fit exactly into one of these broad groups.
					If this is the case, please simply record your hours of teaching in the most appropriate category.
				</p>
				<p>
					<strong>Preparation hours</strong><br />
					This is the time spent on direct preparation of course content, and assessment of students' work, in so far as it can be allocated to different types of teaching.
					It includes preparing materials for lectures, seminars, classes, tutorials, practicals and fieldwork, and writing textbooks and other publications intended primarily for teaching.
					Marking of essays and other tutorial work should be included here; marking of work that cannot be allocated to a particular teaching type should be recorded under "Assessment, examining, admissions, student welfare and other support for teaching", below.
				</p>
			  <p>
				  Preparation also includes administrative work relating to types of teaching, including timetabling, preparing course prospectuses, and department and college committee work relating to teaching, and time spent keeping up to date in your field or exploring new areas with potential benefit to teaching.
				</p>
				<p>
					<strong>Assessment, examining, admissions, student welfare and other support for teaching</strong><br />
					These activities should be allocated to the different student types as far as possible.
					This might include, but is not limited to:
				</p>
				<ol class="note_list">
					<li>assessment and marking of students' work, where it cannot be attributed to different types of teaching;</li>
					<li>examinations, invigilation, setting and marking of papers;</li>
					<li>admissions, including interviews, open days, etc.;</li>
					<li>student administration, including welfare, pastoral care and counselling;</li>
					<li>time spent on the advancement of personal knowledge and skills related to teaching, such as training courses, professional development courses, discussions on teaching feedback.</li>
				</ol>
			  <p>
					Where an activity benefits research as well as teaching, please try to apportion the relevant time between the different activities.  Where activities cannot be attributed to teaching, research or any of the "Other activities" in section C, they should be counted under "General support", in section D.
				</p>
				<p>
					<strong>Special Courses</strong><br />
					These are: non credit-bearing courses; short courses/CPD activity for which fees are charged, including teaching services delivered externally; courses held overseas; any commercial teaching for external organisations (e.g. summer schools organised by other universities); and teaching of non-matriculated students in Oxford (e.g. visiting, recognised or private students, Stanford or Princeton students in Oxford).
					Any examinations associated with these courses should be recorded as "preparation" against this line.
				</p>
      </div>


			<div id="teaching">
			  <h4>Undergraduate Teaching</h4>
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<div class="column_wrapper">
					<div class="label_wrapper"><p>&nbsp;</p></div>
					<div class="column_wrapper">
						<div class="webform-component form-item form-type-header">Direct Contact Hours</div>
						<div class="webform-component form-item form-type-header">Preparation &amp; Assessment</div>
						<div class="webform-component form-item form-type-header">Hours Worked</div>
						<div class="webform-component form-item form-type-header">% of Total</div>
					</div>
				</div>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a01', 'A01: Lectures (including demonstrations in lectures)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a02', 'A02: Tutorials') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a43', 'A43: Seminars and classes (department/faculty)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a53', 'A53: Seminars and classes (college)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a04', 'A04: Laboratory practicals and other laboratory teaching') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a07', 'A07: Other teaching including fieldwork and supervision of project work') ?>
				<?= $survey::prepHoursPercentage($this, 'a48', 'A48: Assessment, examining, admissions, student welfare and other support for UG teaching (dept/faculty)') ?>
				<?= $survey::prepHoursPercentage($this, 'a58', 'A58: Assessment, examining, admissions, student welfare and other support for UG teaching (college)') ?>
  			<hr class="line" />

			  <h4>Postgraduate Teaching</h4>
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<div class="column_wrapper">
					<div class="label_wrapper"><p>&nbsp;</p></div>
					<div class="column_wrapper">
						<div class="webform-component form-item form-type-header">Direct Contact Hours</div>
						<div class="webform-component form-item form-type-header">Preparation &amp; Assessment</div>
						<div class="webform-component form-item form-type-header">Hours Worked</div>
						<div class="webform-component form-item form-type-header">% of Total</div>
					</div>
				</div>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a21', 'A21: Lectures (including demonstrations in lectures)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a22', 'A22: Tutorials') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a63', 'A63: Seminars and classes (department/faculty)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a73', 'A73: Seminars and classes (college)') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a24', 'A24: Laboratory practicals and other laboratory teaching') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a27', 'A27: Other teaching including fieldwork and supervision of project work') ?>
				<?= $survey::prepHoursPercentage($this, 'a68', 'A68: Assessment, examining, admissions, student welfare and other support for PG teaching (dept/faculty)') ?>
				<?= $survey::prepHoursPercentage($this, 'a78', 'A78: Assessment, examining, admissions, student welfare and other support for PG teaching (college)') ?>
  			<hr class="line" />

			  <h4>Postgraduate Researchers Teaching</h4>
  			<?= $this->Form->input('a_pgr', [ 'label'=>'Number of PGR students you are currently supervising and co-supervising, (0.5 for co-supervised students)', 'size'=>4, 'maxlength'=>3, 'templates'=>$waf->template_wrappers('a_pgr','',['inline_wrapper']) ]) ?>
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<div class="column_wrapper">
					<div class="label_wrapper"><p>&nbsp;</p></div>
					<div class="column_wrapper">
						<div class="webform-component form-item form-type-header">Direct Contact Hours</div>
						<div class="webform-component form-item form-type-header">Preparation &amp; Assessment</div>
						<div class="webform-component form-item form-type-header">Hours Worked</div>
						<div class="webform-component form-item form-type-header">% of Total</div>
					</div>
				</div>
				<?= $survey::contactPrepHoursPercentageInput($this, 'b17', 'B17: Supervision of PGR students') ?>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a33', 'A33: Lectures, seminars and classes for PGR students') ?>
				<?= $survey::prepHoursPercentage($this, 'b88', 'B88: Assessment, examining, admissions, student welfare and other support for PGR teaching (dept/faculty)') ?>
				<?= $survey::prepHoursPercentage($this, 'b98', 'B98 Assessment, examining, admissions, student welfare and other support for PGR teaching (college)') ?>
  			<hr class="line" />

			  <h4>Special Courses</h4>
				<div class="column_wrapper">
					<div class="label_wrapper"><p>&nbsp;</p></div>
					<div class="column_wrapper">
						<div class="webform-component form-item form-type-header">Direct Contact Hours</div>
						<div class="webform-component form-item form-type-header">Preparation &amp; Assessment</div>
						<div class="webform-component form-item form-type-header">Hours Worked</div>
						<div class="webform-component form-item form-type-header">% of Total</div>
					</div>
				</div>
				<?= $survey::contactPrepHoursPercentageInput($this, 'a08', 'A08: Short courses, non-matriculated award and non-award-bearing and summer course') ?>

			  <h4>Total</h4>
				<?= $survey::contactPrepHoursPercentageInput($this, 'abt', 'Teaching Total', true) ?>
      </div>


      <p>&nbsp;</p>
			<h3>B. RESEARCH (by teaching method)<sup>*</sup></h3>
      <div id="note2" class="waf-expandable">
        <p>
          <strong>Publicly-funded and non-publicly-funded research</strong><br />
          The University is required to account for time spent on publicly- and non-publicly-funded research, by source of funding.
          Please record (in hours) the time spent on research in each of the relevant categories listed in section B.
        </p>
				<p>
					<strong>Publicly-funded research (B1*)</strong> is defined for these purposes as research which is supported from UK or EC public funds.
					Activity which is funded by the University or is "own funded" is also considered publicly-funded.
					Note that research activity supported by charities is not publicly-funded in this context.
				</p>
				<p>
				  We need to identify separately the percentage of time spent on research, whether identifiable as a specific project or not, where there is no external sponsor (B1.1).
				  For some individuals this forms a high proportion of the total time spent on research.
				  Research entered under this heading includes any speculative research, for example to investigate novel ideas or to assess their potential before preparing a grant or contract bid to a sponsor, whether or not it leads to an outcome.
				  Research time spent on collaborative work with another University department or another University should be built into either this heading or as externally-sponsored work, whichever is most appropriate.
				</p>
				<p>
					<strong>Non-publicly-funded research (B2*)</strong> is research funded by all
					other sources of funding, including charities, businesses and colleges.   Note
					that college-funded research should only include any research sponsored by specific
					college funding; academics holding joint appointments are not required to divide
					their "research where there is no external sponsor" between the University and
					their College.
				</p>
				<p>
				  Please indicate, by the type of project sponsor (whether paying in part or in
					full for the costs of the project), the hours spent on research. Include time spent
					on management of research projects, supervision and training of recruited research staff,
					and production of research reports required under the terms of the grant or contract
					- these are classed as direct research activities, not support activities. Include
					time spent setting up projects for funded Postgraduate students. Also include time spent
					preparing relevant papers for publication in journals, conference proceedings, etc.
				</p>
				<p>
					<strong>Support activities for research</strong>
				</p>
				<ol class="note_list">
					<li>drafting proposals for bids to external bodies</li>
					<li>negotiating contracts</li>
					<li>peer review, scholarly work and advancement of personal knowledge and skills in relation to research</li>
					<li>acquiring new technical skills</li>
					<li>attendance at professional conferences</li>
					<li>time in other institutions on research exchange scheme</li>
					<li>advisory work for Government departments or committees if unpaid and where it enhances or potentially benefits your research work; </li>
					<li>exceptional time spent in a given year on procurement of special research equipment, such as liaison with suppliers over specifications for custom made items, installation and commissioning of the equipment;</li>
					<li>administrative work including departmental or University committee work, faculty tasks etc., where relevant to research.</li>
					<li>time spent by Libraries and Museum staff in support of research by others</li>
				</ol>
        <p>
          Note that general management or committee work not <em>specifically supporting research or teaching</em> should be included in section D of the form, "general support".
        </p>
      </div>

			<div id="research">
			  <h4>Publicly Funded Research</h4>
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<?= $survey::hoursPercentage($this, 'b11', 'B1.1: University research where there is no external sponsor') ?>
				<?= $survey::hoursPercentage($this, 'b12', 'B1.2: Research Councils') ?>
				<?= $survey::hoursPercentage($this, 'b13', 'B1.3: UK Government bodies (inc. Local Authorities, Health Authorities etc.)') ?>
				<?= $survey::hoursPercentage($this, 'b14', 'B1.4: European Commission; European Social Fund') ?>
				<?= $survey::hoursPercentage($this, 'b1t', 'Total direct time spent on Publicly Funded Research', true) ?>

			  <h4>Non-Publicly Funded Research</h4>
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<?= $survey::hoursPercentage($this, 'b21', 'B2.1: College funded research (Not CUF)') ?>
				<?= $survey::hoursPercentage($this, 'b22', 'B2.2: UK-based charities') ?>
				<?= $survey::hoursPercentage($this, 'b23', 'B2.3: UK industry, commerce and public corporations') ?>
				<?= $survey::hoursPercentage($this, 'b24', 'B2.4: Other sources (UK)') ?>
				<?= $survey::hoursPercentage($this, 'b25', 'B2.5: EU countries (all sources other than European Commission)') ?>
				<?= $survey::hoursPercentage($this, 'b26', 'B2.6: Other overseas (all sources)') ?>
				<?= $survey::hoursPercentage($this, 'b2t', 'Total direct time spent on Non-Publicly Funded Research', true) ?>

			  <h4>Research Support</h4>
				<?= $survey::hoursPercentage($this, 'b31', 'B3.1: Total time spent on support for research') ?>

			  <h4>Total</h4>
				<?= $survey::hoursPercentage($this, 'bt', 'Total time spent on Research', true) ?>
      </div>

      <p>&nbsp;</p>
			<h3>C. OTHER ACTIVITIES<sup>*</sup></h3>
      <div id="note3" class="waf-expandable">
				<p>
				  <strong> Clinical duties performed (NHS Knock for Knock)</strong><br />
				  If "named sessions" are specified as part of a clinician's contract then this can be used as the basis for allocating your time. In other cases, the time spent on clinical duties might be assumed to be the element of the clinician's time paid by the NHS.
				</p>
				<p>
				  <strong>Other professional work</strong><br />
				  Include here any activities that are neither teaching nor research but which are carried out in University time and <em>have an identifiable income stream</em>.
				  For example:
				</p>
				<ol class="note_list">
					<li>provision of services to industry through contracts between the University and a company for the use of University expertise and/or facilities;</li>
					<li>consultancy work of a private nature carried out within the permitted thirty days per year;</li>
					<li>technology transfer work, including directorships of start-up companies, and/or consultancy contracts for the companies if such work is remunerated. (Note: If such work is not remunerated, the time spent should be included in section D: general support); </li>
					<li>other services rendered including work undertaken in University time and paid for by non-academic departments or units (such as residences, or catering);</li>
					<li>advisory work for government departments or committees, if remunerated. This includes time on services to Research Council committees. (Note: time on unpaid work of this type should be allocated to support for teaching, research or other (or a combination of these) where appropriate);</li>
					<li>commissioned professional work - e.g. editing a journal for remuneration.</li>
				</ol>
				<p>
				  <strong>Other activities without an identifiable income stream</strong><br />
				  Include here any activities that are neither teaching nor research, which are carried out in University time and <em>do not have an identifiable income stream</em>.
				  For example:
				</p>
				<ol class="note_list">
					<li>drafting and negotiating contracts for other activities (but not for research contracts, where the time should be accounted for under Research);</li>
					<li>unpaid technology transfer work - e.g. supporting patent applications, licence negotiations;</li>
					<li>formation of start-up companies;</li>
					<li>any non-remunerated support activity (include such support that cannot be linked meaningfully with either support to teaching or support to research);</li>
					<li>activities related to ecclesiastical responsibilities.</li>
				</ol>
      </div>

			<div id="other">
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<?= $survey::hoursPercentage($this, 'c1', 'C1: Clinical duties performed (NHS Knock for Knock)') ?>
				<?= $survey::hoursPercentage($this, 'c1a', 'C1a: Clinical duties performed (Overseas)') ?>
				<?= $survey::hoursPercentage($this, 'c2', 'C2: Non-Research Clinical Trials') ?>
				<?= $survey::hoursPercentage($this, 'c3', 'C3: Services for the General Public') ?>
				<?= $survey::hoursPercentage($this, 'c4', 'C4: Other professional work') ?>
				<?= $survey::hoursPercentage($this, 'c5', 'C5: Public Service (e.g. Jury Service, School Governors, Magistrates etc.)') ?>
				<?= $survey::hoursPercentage($this, 'c6', 'C6: Support for above activities') ?>
				<?= $survey::hoursPercentage($this, 'ct', 'Total spent on Other Activities', true) ?>
			</div>


			<h3>D. GENERAL SUPPORT<sup>*</sup></h3>
      <div id="note4" class="waf-expandable">
				<p>
				  This section covers time spent on Support Activities that cannot be attributed to Support for Teaching or Research or Other Activities, such as internal management (e.g. Safety Officer; training on new Finance system; work on strategic review) or committee work (e.g. Council; General Board; College Governing Body).
          Include here any advisory work for Government, which is not attributable to Teaching, Research, or Other activities. You should also include Continuing Professional Development (CPD) and attendance at internal training courses.
        </p>
      </div>

			<div id="general">
				<p><strong>Enter the hours<strong><sup>**</sup></strong> spent on each activity:</strong></p>
				<?= $survey::hoursPercentage($this, 'd11', 'D1.1: University/faculty/department administration and committee work') ?>
				<?= $survey::hoursPercentage($this, 'd12', 'D1.2: Continuing Professional Development and Training') ?>
				<?= $survey::hoursPercentage($this, 'd21', 'D2.1: College administration &amp; Committee work') ?>
				<?= $survey::hoursPercentage($this, 'd13', 'D1.3: Other general support') ?>
				<?= $survey::hoursPercentage($this, 'dt', 'Total spent on General Support', true) ?>
			</div>


      <p>&nbsp;</p>
			<h3>OVERALL TOTAL FOR PERIOD</h3>
			<?= $survey::hoursPercentage($this, 'tt', '', true) ?>

      <p>&nbsp;</p>
      <p><strong><sup>*</sup> Note:</strong> Extra information on how to complete each section of this form can be accessed by clicking the "Show Notes" button in that section.</p>
      <p><strong><sup>**</sup> Note:</strong> Fractions of hours must be input in decimals to a maximum of two decimal places.</p>

      <hr class="line" />

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Report'), [ 'name'=>'action', 'value'=>'report' ]);
					echo $this->Form->button('Clear', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
	</div>
</div>