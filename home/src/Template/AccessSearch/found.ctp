<!-- File: src/Template/AccessSearch/found.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>Search Results</h3>
		<p class="search_results">
			Your search found <?= $total ?> matching building<?= $s ?> or department<?= $s ?>
		</p>

		<?php
			foreach ($buildings as $building) {
				$accessibility = $building['accessibility'];
				$url = $accessibility['access_guide_url'];
				$files = isset($building['_embedded']['files']) ? $building['_embedded']['files'] : [];
				$primary_pictures = [];
				if (isset($files) && gettype($files=="array")) {
					foreach ($files as $file) if (isset($file['primary'])) $primary_pictures[] = $file['url'];
				}
				$primary_picture = count($primary_pictures)>0 ? '<a href="'.$url.'"><img src="http:'.$primary_pictures[0].'" alt="Picture of '.$building['name'].'" width="255" class="floated"  target="_blank" /></a>' : '';
				$map_link = '<a href="'.$AccessSearch->param['mapURL'].$building['id'].'" target="_blank">View map in OxPoints</a>';
		?>

    <div class="separator">
			<hr class="line">
			<h1>
					<a href="<?= $accessibility['access_guide_url'] ?>">
						<?= utf8_decode($building['name']) ?>
					</a>
			</h1>

      <div class="column_wrapper">

				<!--Beginning of the left column-->
				<div id="left" style="flex:4">
					<h2 class="ag-secondary-header">
						<a href="<?= $url ?>" class="subcontent" style="color:#FF9001;">
							<?= (isset($accessibility['access_guide_contents'])?$accessibility['access_guide_contents']:'') ?>
						</a>
					</h2>
					<p><?= $primary_picture ?></p>
					<p><?= $map_link ?></p>
					<div class="clear"></div>
				</div> <!-- end of left div-->

				<!--Beginning of the right column-->
				<div id="right">

				<!--start of first accordion-->
				<div class="accord">
						<div class="morelessg-text clearfix withRepImage First dashed">
								<div class="morelessg-heading clearfix">

										<h2 data-behaviour="oxToggleMoreLess1">At a glance</h2>
										<a data-behaviour="oxToggleMoreLess" data-behaviour-type="click" href="javascript:void(0);">+ more</a>
										<div class="morelessg-intro">
										<!-- This section contains information about accessibility -->
										</div>
								</div>
								<div class="morelessg-content">
										<table>
												<tbody>
										<?php
										$html = '';
										$html .= '<tr>
														<td>On-site disabled parking spaces</th>
														<td><strong>'.((isset($accessibility['number_of_disabled_parking_spaces']) and $accessibility['number_of_disabled_parking_spaces']<>'')? $accessibility['number_of_disabled_parking_spaces']: '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Parking nearby (within 200m)</th>
														<td><strong>'.((isset($accessibility['parking_type']) and $accessibility['parking_type']<>'')? $accessibility['parking_type']:'-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Main entrance</th>
														<td><strong>'.((isset($accessibility['primary_entrance_levelness']) and $accessibility['primary_entrance_levelness']<>'')?$accessibility['primary_entrance_levelness']:'-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Alternative entrance (level access)</th>
														<td>'.((isset($accessibility['Alternative_entrance']) and $accessibility['Alternative_entrance']<>'') ? $accessibility['Alternative_entrance'] : '-').'</td>
												</tr>';
										$html .= '<tr>
														<td>Door entry</th>
														<td><strong>'.((isset($accessibility['primary_entrance_opening_type']) and $accessibility['primary_entrance_opening_type']<>'') ? $accessibility['primary_entrance_opening_type'] : '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Direct contact to reception</th>
														<td><strong>'.((isset($accessibility['contact_method_from_entrance_to_reception']) and $accessibility['contact_method_from_entrance_to_reception']<>'') ? $accessibility['contact_method_from_entrance_to_reception'] : '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Number of floors</th>
														<td><strong>'.((isset($accessibility['number_of_floors']) and $accessibility['number_of_floors']<>'')? $accessibility['number_of_floors'] : '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Accessible toilets</th>
														<td><strong>'.((isset($accessibility['number_of_accessible_toilets']) and $accessibility['number_of_accessible_toilets']<>'')? $accessibility['number_of_accessible_toilets'] : '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Lift to all floors</th>
														<td><strong>'.((isset($accessibility['has_lifts_to_all_floors']) and $accessibility['has_lifts_to_all_floors']<>'') ?$AccessSearch->YesOrNo($accessibility['has_lifts_to_all_floors']):'-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Hearing support system</th>
														<td><strong>'.((isset($accessibility['has_hearing_system']) and $accessibility['has_hearing_system']<>'')? $AccessSearch->YesOrNo($accessibility['has_hearing_system']): '-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Accessible cafe</th>
														<td><strong>'.((isset($accessibility['has_hearing_system']) and $accessibility['has_hearing_system']<>'')? $AccessSearch->YesOrNo($accessibility['has_hearing_system']):'-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Accessible furniture</th>
														<td><strong>'.((isset($accessibility['has_cafe_refreshments']) and $accessibility['has_hearing_system']<>'')? $AccessSearch->YesOrNo($accessibility['has_adapted_furniture']):'-').'</strong></td>
												</tr>';
										$html .= '<tr>
														<td>Computer Access</th>
														<td><strong>'.((isset($accessibility['has_cafe_refreshments']) and $accessibility['has_hearing_system']<>'')? $AccessSearch->YesOrNo($accessibility['has_computer_access']):'-').'</strong></td>
												</tr>';
										echo $html;
										?>
												</tbody>
										</table>
										</div>
								</div>
						</div>
				<!--end of third accordion-->


				<!--start of second accordion-->
				<div class="accord">
						<div class="morelessg-text clearfix withRepImage Middle dashed">
								<div class="morelessg-heading clearfix">
										<h2 data-behaviour="oxToggleMoreLess">Access enquiries</h2>
												<a data-behaviour="oxToggleMoreLess" data-behaviour-type="click" href="javascript:void(0);">+ more</a>
										<div class="morelessg-intro">
				<!--    Remove              This section contains information about contact person-->
										</div>
								</div>
								<div class="morelessg-content">

								<div class="vcard" >
								<?php
								$html = '';
								$html .= (isset($accessibility['contact_name']) and $accessibility['contact_name']<>'') ? '<p><span class="fn">'.$accessibility['contact_name'].'</span></p>' : '';
								$html .= (isset($accessibility['contact_email']) and $accessibility['contact_email']<>'') ? '<p><a class="email" href="'.$accessibility['contact_email'].'">'.str_replace('mailto:', '', $accessibility['contact_email']).'</a></p>' : '';
								$html .= (isset($accessibility['contact_tel']) and $accessibility['contact_tel']<>'') ? '<p><span classs="tel">'.str_replace('tel:', '', $accessibility['contact_tel']).'</span></p>' : '';
								echo $html;
								?>

								</div><!-- class="vcard"-->
								</div>
						</div>
				</div>
				<!--end of third accordion-->
				<!--start of send accordion-->
				<div class="accord">
						<div class="morelessg-text clearfix withRepImage dashed Last" >
								<div class="morelessg-heading clearfix">
										<h2 data-behaviour="oxToggleMoreLess" >Opening times</h2>
												<a data-behaviour="oxToggleMoreLess" data-behaviour-type="click" href="javascript:void(0);">+ more</a>
										<div class="morelessg-intro">
				<!--                  This section contains information about opening times     -->
										</div>
								</div>
								<div class="morelessg-content">
								<?php
								$html = '';
								$html .= '<h3>Term time</h3>';
								if(isset($accessibility['opening_hours_term_time']) and $accessibility['opening_hours_term_time']<>''){
										$html .= '<div><!--<strong>Staffed hours</strong>--><p style="padding:0 0 0 15px;">'.$accessibility['opening_hours_term_time'].'</p></div>';
								} else {
										$html .= '<p style="padding:0 0 0 15px;">Not available</p>';
								}

								$html .= '<h3>Vacation Time</h3>';
								if(isset($accessibility['opening_hours_vacation']) and $accessibility['opening_hours_vacation']<>''){
										$html .= '<div><p style="padding:0 0 0 15px;">'.$accessibility['opening_hours_vacation'].'</p></div>';

								} else {
										$html .= '<p style="padding:0 0 0 15px;">Not available</p>';
								}

								$html .= '<h3>Closed</h3>';
								if(isset($accessibility['opening_hours_closed']) and $accessibility['opening_hours_closed']<>''){
										$html .= '<div><p style="padding:0 0 0 15px;">'.$accessibility['opening_hours_closed'].'</p></div>';
								} else {
										$html .= '<p style="padding:0 0 0 15px;">Not available</p>';
								}

								echo $html;
								?>
								</div>
						</div>
						<div style="padding: 10px 0 0 300px;">
								<a href = "<?php echo $accessibility['access_guide_url'];?>" >
										<img src="http://www.admin.ox.ac.uk/media/global/wwwadminoxacuk/localsites/accessguide/images/symbols/t4_6822137366933749191.jpg" alt="More Info" height="40" >
								</a>
						</div>
				</div>
				<!--end of second accordion-->

				</div> <!--end of #right column-->

			</div>
			<div class="clear"></div>
		</div><!--end of id .separator -->

		<?php } // end of foreach($buildings) ?>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Search Again', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

  </div>
</div>
