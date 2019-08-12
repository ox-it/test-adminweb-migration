<!-- File: src/Template/Harassment/success.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>
		  Harassment Statement - Submission Success
		</h3>

		<?php
		  if (!empty($survey)) :
		?>

    <p> Thank you for filling out the report.</p>
    <p> The following information has been recorded:</p>

    <h4><?= h($user->name) ?> - <?= !empty($departments[$survey->deptcode]) ? $departments[$survey->deptcode] : (!empty($user->harassment_departments[0]->deptalpha) ? $user->harassment_departments[0]->deptalpha :'Unknown department') ?></h4>
   
   <?= $waf->postValueWithLabel($survey->{'1_date_of_first_meeting'}, 'Date of first meeting') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'2_supporting'}, 'You are representing') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'2_other'}, 'Other') ?>	
   <?= $waf->postValueWithLabelIfNotZero($survey->{'3_complainant_department'}, 'Complainant(s) department, faculty or college') ?>
   
   
   <label class="gapabove">4. The complaintant(s) is / are:</label>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_university_staff_male'}, 'University Staff, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_university_staff_female'}, 'University Staff, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_university_staff_other'}, 'University Staff, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_university_staff_unknown'}, 'University Staff, Unknown') ?>
   
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_college_staff_male'}, 'College Staff, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_college_staff_female'}, 'College Staff, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_college_staff_other'}, 'College Staff, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_college_staff_unknown'}, 'College Staff, Unknown') ?>
       
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_male'}, 'Undergraduate Student, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_female'}, 'Undergraduate Student, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_other'}, 'Undergraduate Student, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_unknown'}, 'Undergraduate Student, Unknown') ?>
 
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_male'}, 'Undergraduate Student, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_female'}, 'Undergraduate Student, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_other'}, 'Undergraduate Student, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_undergraduate_student_unknown'}, 'Undergraduate Student, Unknown') ?>   
 
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_graduate_student_male'}, 'Graduate Student, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_graduate_student_female'}, 'Graduate Student, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_graduate_student_other'}, 'Graduate Student, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_graduate_student_unknown'}, 'Graduate Student, Unknown') ?> 

   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_unknown_male'}, 'Unknown, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_unknown_female'}, 'Unknown, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_unknown_other'}, 'Unknown, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_unknown_unknown'}, 'Unknown, Unknown') ?>    
      	   
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_other_male'}, 'Other, Male') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_other_female'}, 'Other, Female') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_other_other'}, 'Other, Other') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'4_other_unknown'}, 'Other, Unknown') ?>
   
   <label class="gapabove">5. Nature of behaviour / incident described:</label>
  
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_offensive'}, 'Offensive comments or body language, including insults, jokes or gestures (written, face-to-face or through a third party)') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_bullying'}, 'Bullying') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_isolation'}, 'Isolation from work or study') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_hostility'}, 'Hostility, verbal or physical threats') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_malicious'}, 'Malicious rumours') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_embarrassing'}, 'Embarrassing or patronising behaviour or comments, humiliating and/or demeaning criticism') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_physical'}, 'Physical abuse / assault') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_sexual_harassment'}, 'Sexual harassment') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_sexual_assult'}, 'Sexual assault / rape') ?>
   <?= $waf->postValueWithLabelIfNotZero($survey->{'5_stalking'}, 'Stalking') ?>
   <?= $waf->postValueWithLabel($survey->{'5_other'}, 'Other (Please specify)') ?>		   
		   
  <label class="gapabove">6. In the eyes of the complainant the behaviour explicitly related to:</label>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_age'}, 'Age') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_disability'}, 'Disability') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_gender'}, 'Gender') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_pregnancy'}, 'Pregnancy / maternity') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_race'}, 'Race') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_religion'}, 'Religion or belief') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_sexuality'}, 'Sexual Orientation') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_transgender'}, 'Transgender') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'6_other'}, 'Other') ?>
  
  		   
  <label class="gapabove">7. Department, faculty or college that the person(s) complained about belongs to:</label>		   
  <?= $waf->postValueWithLabelIfNotZero($survey->{'7_accused_dept'}, 'Department') ?>
  
  <label class="gapabove">8. The person(s) complained about is / are:</label>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_university_staff_male'}, 'University Staff, Male') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_university_staff_female'}, 'University Staff, Female') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_university_staff_other'}, 'University Staff, Other') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_university_staff_unknown'}, 'University Staff, Unknown') ?>
 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_college_staff_male'}, 'College Staff, Male') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_college_staff_female'}, 'College Staff, Female') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_college_staff_other'}, 'College Staff, Other') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_college_staff_unknown'}, 'College Staff, Unknown') ?>
  
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_undergraduate_student_male'}, 'Undergraduate Student, Male') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_undergraduate_student_female'}, 'Undergraduate Student, Female') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_undergraduate_student_other'}, 'Undergraduate Student, Other') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_undergraduate_student_unknown'}, 'Undergraduate Student, Unknown') ?>
 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_graduate_student_male'}, 'Graduate Student, Male') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_graduate_student_female'}, 'Graduate Student, Female') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_graduate_student_other'}, 'Graduate Student, Other') ?>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'8_graduate_student_unknown'}, 'Graduate Student, Unknown') ?> 
  
  <label class="gapabove">9. Steps the person you are supporting intends to take next:</label>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_no_further_action'}, 'No further action at this time') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_pursue_training'}, 'Pursue training, coaching, mentoring opportunities') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_contact_agencies'}, 'Contacting internal or external agencies or support services') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_tell_person'}, 'Tell the person that they are unhappy with their behaviour') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_seek_help'}, 'Seek help from their department / college to facilitate an informal resolution (including mediation)') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_formal_complaint'}, 'Submit a formal complaint') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'9_other'}, 'Other') ?> 
  
  <label class="gapabove">10.The person you are supporting has been in touch with:</label>
  <?= $waf->postValueWithLabelIfNotZero($survey->{'10_harassment_line'}, 'Harassment Line') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'10_welfare_and_support'}, 'Student Welfare and Support Services') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'10_proctors_office'}, 'The Proctors Office') ?> 
  <?= $waf->postValueWithLabelIfNotZero($survey->{'10_local_central_hr'}, 'Local or Central HR') ?> 

<?php
  endif //form empty?
?>
    <p>
      <?= $waf->postButtonToReferer($this, 'Return to Harassement Start Page') ?>
    </p>

	</div>
</div>
