
<div class="row">
<div class="waf-include">
<?php

echo '1_date_of_first_meeting, ';
echo '2_supporting, ';
echo '2_other, ';
echo '3_complainant_department, ';
echo '4_university_staff_male, ';
echo '4_university_staff_female, ';
echo '4_university_staff_other, ';
echo '4_university_staff_unknown, ';
echo '4_college_staff_male, ';
echo '4_college_staff_female, ';
echo '4_college_staff_other, ';
echo '4_college_staff_unknown, ';
echo '4_undergraduate_student_male, ';
echo '4_undergraduate_student_female, ';
echo '4_undergraduate_student_other, ';
echo '4_undergraduate_student_unknown, ';
echo '4_graduate_student_male, ';
echo '4_graduate_student_female, ';
echo '4_graduate_student_other, ';
echo '4_graduate_student_unknown, ';
echo '4_unkonwn_male, ';
echo '4_unkonwn_female, ';
echo '4_unkonwn_other, ';
echo '4_unkonwn_unknown, ';
echo '5_offensive, ';
echo '5_bullying, ';
echo '5_isolation, ';
echo '5_hostility, ';
echo '5_mailcious, ';
echo '5_embarrassing, ';
echo '5_physical, ';
echo '5_sexual_harassment, ';
echo '5_sexual_assault, ';
echo '5_stalking, ';
echo '5_other, ';
echo '6_age, ';
echo '6_disability, ';
echo '6_gender, ';
echo '6_pregnancy, ';
echo '6_race, ';
echo '6_religion, ';
echo '6_sexual_orientation, ';
echo '6_transgender, ';
echo '6_other, ';
echo '7_accused_dept, ';
echo '8_university_staff_male, ';
echo '8_university_staff_female, ';
echo '8_university_staff_other, ';
echo '8_university_staff_unknown, ';
echo '8_college_staff_male, ';
echo '8_college_staff_female, ';
echo '8_college_staff_other, ';
echo '8_college_staff_unknown, ';
echo '8_undergraduate_student_male, ';
echo '8_undergraduate_student_female, ';
echo '8_undergraduate_student_other, ';
echo '8_undergraduate_student_unknown, ';
echo '8_graduate_student_male, ';
echo '8_graduate_student_female, ';
echo '8_graduate_student_other, ';
echo '8_graduate_student_unknown, ';
echo '8_student_unknown_male, ';
echo '8_student_unknown_female, ';
echo '8_student_unknown_other, ';
echo '8_student_unknown_unknown, ';
echo '8_unknown_male, ';
echo '8_unknown_female, ';
echo '8_unknown_other, ';
echo '8_unknown_unknown, ';
echo '8_other_male, ';
echo '8_other_female, ';
echo '8_other_unknown, ';
echo '8_other_other, '; 
echo '9_no_further_action, ';
echo '9_pursue_training, ';
echo '9_contact_agencies, ';
echo '9_tell_person, ';
echo '9_seek_help, ';
echo '9_formal_complaint, ';
echo '9_other, ';
echo '10_harassment_line, ';
echo '10_welfare_and_support, ';
echo '10_proctors_office,';
echo '10_local_central_hr';
echo "\n";

foreach($surveys as $survey) {
	echo $survey['1_date_of_first_meeting'] . ', ';
	
	if ($survey['2_supporting'] == 0) {
		echo 'Complainant, ';
	}
	else if ($survey['2_supporting'] == 1) {
		echo 'Alleged harasser, ';
	}
	else if ($survey['2_supporting'] == 2) {
		echo 'other, '; 
	}


	echo $survey['2_other'] . ', ';
	echo $survey['cd']['deptalpha'] . ', ';
	echo $survey['4_university_staff_male'] . ', ';
	echo $survey['4_university_staff_female'] . ', ';
	echo $survey['4_university_staff_other'] . ', ';
	echo $survey['4_university_staff_unknown'] . ', ';
	echo $survey['4_college_staff_male'] . ', ';
	echo $survey['4_college_staff_female'] . ', ';
	echo $survey['4_college_staff_other'] . ', ';
	echo $survey['4_college_staff_unknown'] . ', ';
	echo $survey['4_undergraduate_student_male'] . ', ';
	echo $survey['4_undergraduate_student_female'] . ', ';
	echo $survey['4_undergraduate_student_other'] . ', ';
	echo $survey['4_undergraduate_student_unknown'] . ', ';
	echo $survey['4_graduate_student_male'] . ', ';
	echo $survey['4_graduate_student_female'] . ', ';
	echo $survey['4_graduate_student_other'] . ', ';
	echo $survey['4_graduate_student_unknown'] . ', ';
	echo $survey['4_unkonwn_male'] . ', ';
	echo $survey['4_unkonwn_female'] . ', ';
	echo $survey['4_unkonwn_other'] . ', ';
	echo $survey['4_unkonwn_unknown'] . ', ';
	echo $survey['5_offensive'] . ', ';
	echo $survey['5_bullying'] . ', ';
	echo $survey['5_isolation'] . ', ';
	echo $survey['5_hostility'] . ', ';
	echo $survey['5_mailcious'] . ', ';
	echo $survey['5_embarrassing,'] . ', ';
	echo $survey['5_physical'] . ', ';
	echo $survey['5_sexual_harassment'] . ', ';
	echo $survey['5_sexual_assault'] . ', ';
	echo $survey['5_stalking'] . ', ';
	echo $survey['5_other'] . ', ';
	echo $survey['6_age'] . ', ';
	echo $survey['6_disability'] . ', ';
	echo $survey['6_gender'] . ', ';
	echo $survey['6_pregnancy'] . ', ';
	echo $survey['6_race'] . ', ';
	echo $survey['6_religion'] . ', ';
	echo $survey['6_sexual_orientation'] . ', ';
	echo $survey['6_transgender'] . ', ';
	echo $survey['6_other'] . ', ';
	echo $survey['ad']['deptalpha'] . ', ';
	echo $survey['8_university_staff_male'] . ', ';
	echo $survey['8_university_staff_female'] . ', ';
	echo $survey['8_university_staff_other'] . ', ';
	echo $survey['8_university_staff_unknown'] . ', ';
	echo $survey['8_college_staff_male'] . ', ';
	echo $survey['8_college_staff_female'] . ', ';
	echo $survey['8_college_staff_other'] . ', ';
	echo $survey['8_college_staff_unknown'] . ', ';
	echo $survey['8_undergraduate_student_male'] . ', ';
	echo $survey['8_undergraduate_student_female'] . ', ';
	echo $survey['8_undergraduate_student_other'] . ', ';
	echo $survey['8_undergraduate_student_unknown'] . ', ';
	echo $survey['8_graduate_student_male'] . ', ';
	echo $survey['8_graduate_student_female'] . ', ';
	echo $survey['8_graduate_student_other'] . ', ';
	echo $survey['8_graduate_student_unknown'] . ', ';
	echo $survey['8_student_unknown_male'] . ', ';
	echo $survey['8_student_unknown_female'] . ', ';
	echo $survey['8_student_unknown_other'] . ', ';
	echo $survey['8_student_unknown_unknown'] . ', ';
	echo $survey['8_unknown_male'] . ', ';
	echo $survey['8_unknown_female'] . ', ';
	echo $survey['8_unknown_other'] . ', ';
	echo $survey['8_unknown_unknown'] . ', ';
	echo $survey['8_other_male'] . ', ';
	echo $survey['8_other_female'] . ', ';
	echo $survey['8_other_unknown'] . ', ';
	echo $survey['8_other_other'] . ', '; 
	echo $survey['9_no_further_action'] . ', ';
	echo $survey['9_pursue_training'] . ', ';
	echo $survey['9_contact_agencies'] . ', ';
	echo $survey['9_tell_person'] . ', ';
	echo $survey['9_seek_help'] . ', ';
	echo $survey['9_formal_complaint'] . ', ';
	echo $survey['9_other'] . ', ';
	echo $survey['10_harassment_line'] . ', ';
	echo $survey['10_welfare_and_support'] . ', ';
	echo $survey['10_proctors_office'] . ', ';
	echo $survey['10_local_central_hr'];
	echo "\n";
	
}
	
?>
<script type="text/javascript">

jQuery(document).ready(function(){
	var results = jQuery('.webform-client-form').text();
	var link = document.createElement('a');
	 jQuery('.webform-client-form').remove();

	link.setAttribute('download', 'surveys.csv');
	link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(results));
	link.click();

});

</script>
</div></div>
