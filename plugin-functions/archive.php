<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	echo '<h2>Archive</h2>';
	if( ! current_user_can('administrator'))
	{
		echo "Access denied.<br />You need to be an Administrator to access this file.";
		die;
	}
		echo '<table style="max-width:80%; border:0; padding: 5px;">
		            <thead style="background-color: #4f79bc; color: white;">
		      		    <td style="padding: 8px;">ID</td>
		      		    <td style="padding: 8px;">Name</td>
		      		    <td style="padding: 8px;">Surname</td>
		      		    <td style="padding: 8px;">Gender</td>
		      		    <td style="padding: 8px;">Email</td>
		      		    <td style="padding: 8px;">Address</td>
		      		    <td style="padding: 8px;">Town</td>
		      		    <td style="padding: 8px;">Postcode</td>
		      		    <td style="padding: 8px;">Country</td>
		      		    <td style="padding: 8px;">Country of Origin</td>
		      		    <td style="padding: 8px;">Tel Land Line</td>
		      		    <td style="padding: 8px;">Tel Mobile</td>
		      		    <td style="padding: 8px;">Date of Birth</td>
		      		    <td style="padding: 8px;">Position</td>
		      		    <td style="padding: 8px;">Years of Experiences</td>
		      		    <td style="padding: 8px;">Passport No.</td>
		      		    <td style="padding: 8px;">Education</td>
		      		    <td style="padding: 8px;">Agent</td>
		      	    </thead>
				  <tbody style="background-color: white; color: black;">';
				global $wpdb;
				$sql = "SELECT * FROM $table_archive";
				$result = $wpdb->get_results($sql, ARRAY_A);
				foreach($result as $row)
				{
					if(isset($row['position_id']))
					{
						$position_id = sanitize_text_field($row['position_id']);
						$sql1 = "SELECT name FROM $table_positions WHERE id= %d";
						$result1 = $wpdb->get_row($wpdb->prepare($sql1, $position_id), ARRAY_A);
						$name = sanitize_text_field($result1['name']);
					}
					else if(isset($row['position_other']))
					{
						$name = sanitize_text_field($row['position_other']);
					}
					if (isset($row['education']))
					{
						$sql2 = "SELECT name FROM $table_education_levels WHERE id= %d";
						$result2 = $wpdb->get_row($wpdb->prepare($sql2, sanitize_text_field($row['education'])), ARRAY_A);
								$education = sanitize_text_field($result2['name']);
					}
					if (isset($row['agent_id']))
					{
						$sql3 = "SELECT name, surname FROM $table_agents WHERE id= %d";
						$result3 = $wpdb->get_row($wpdb->prepare($sql3, sanitize_text_field($row['agent_id'])), ARRAY_A);
							$agent = sanitize_text_field($result3['name']) . " " . sanitize_text_field($result3['surname']);
					}
					if (isset ($row['country']))
					{
						$sql4 = "SELECT country_name FROM $table_countries WHERE id= %d";
						$result4 = $wpdb->get_row($wpdb->prepare($sql4, sanitize_text_field($row['country'])), ARRAY_A);
							$country = sanitize_text_field($result4['country_name']);
					}
					if (isset ($row['country_origin']))
					{
						$sql5 = "SELECT country_name FROM $table_countries WHERE id= %d";
						$result5 = $wpdb->get_row($wpdb->prepare($sql5, sanitize_text_field($row['country_origin'])), ARRAY_A);
							$country_origin = sanitize_text_field($result5['country_name']);
					}
					echo '<tr>
					      <td>
					      <form method="post">
					      <input type="hidden" name="submission" value="'.esc_html($row['id']).'">
					      <a href="#" onclick="this.parentNode.submit(); return false;">'.esc_html($row['id']).'</a>
					      </form>
					      </td>
					      <td>'.esc_html($row['name']).'</td>
					      <td>'.esc_html($row['surname']).'</td>
					      <td>'.esc_html($row['gender']).'</td>
					      <td>'.esc_html($row['email']).'</td>
					      <td>'.esc_html($row['address']).'</td>
					      <td>'.esc_html($row['town']).'</td>
					      <td>'.esc_html($row['postcode']).'</td>
					      <td>'.esc_html($country).'</td>
					      <td>'.esc_html($country_origin).'</td>
					      <td>'.esc_html($row['tel_land_line']).'</td>
					      <td>'.esc_html($row['tel_mobile']).'</td>
					      <td>'.esc_html($row['date_of_birth']).'</td>
					      <td>'.esc_html(strtoupper($name)).'</td>
					      <td>'.esc_html($row['xp']).'</td>
					      <td>'.esc_html($row['passport_number']).'</td>
					      <td>'.esc_html($education).'</td>
					      <td>'.esc_html($agent).'</td>
					      </tr>';
                }
				echo '</tbody>
		      	  </table>
	      	  </div>';