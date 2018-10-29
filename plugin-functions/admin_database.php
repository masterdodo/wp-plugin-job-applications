	<?php
	if ( ! defined( 'ABSPATH' ) ) exit;

	echo '<div id="wrap">';

	if( ! current_user_can('administrator'))
	{
		echo "Access denied.<br />You need to be an Administrator to access this file.";
		die;
	}
	if (isset ($_POST['submission']))
	{
		if( ! current_user_can('administrator'))
		{
			echo "Access denied.<br />You need to be an Administrator to access this file.";
			die;
		}
		echo '<table style="max-width:80%; border:0; padding: 5px;">';
			$post_submission = sanitize_text_field($_POST['submission']);
			global $wpdb;
			$sql = "SELECT * FROM $table_applications WHERE (id= %d)";
			$result = $wpdb->get_results($wpdb->prepare($sql, $post_submission), ARRAY_A);
			foreach($result as $row)
			{
				$application_id = intval($row['id']);
				$name = sanitize_text_field($row['name']);
				$surname = sanitize_text_field($row['surname']);
				$gender = sanitize_text_field($row['gender']);
				$email = sanitize_email($row['email']);
				$address = sanitize_text_field($row['address']);
				$town = sanitize_text_field($row['town']);
				$postcode = sanitize_text_field($row['postcode']);
				$tel_land_line = intval($row['tel_land_line']);
				$tel_mobile = intval($row['tel_mobile']);
				$passport_number = sanitize_text_field($row['passport_number']);
				$xp = intval($row['xp']);
				$skill = sanitize_text_field($row['skill']);
				$position_id = intval($row['position_id']);
				$education_id = intval($row['education']);
				$agent_id = intval($row['agent_id']);
				$date_of_birth = sanitize_text_field($row['date_of_birth']);
    			$date_of_birth = new DateTime($date_of_birth);
    			$date_of_birth = $date_of_birth->format("d. m. Y");
				$country_id = intval($row['country']);
				$country_origin_id = intval($row['country_origin']);
				if(isset($row['position_other']))
				{
					$position = sanitize_text_field($row['position_other']);
					$position_other = sanitize_text_field($row['position_other']);
				}
			}
			
			if(isset ($position_id))
			{
				global $wpdb;
				$sql1 = "SELECT name FROM $table_positions WHERE id= %d";
				$result1 = $wpdb->get_row($wpdb->prepare($sql1, $position_id), ARRAY_A);
				$position = $result1['name'];
			}
			if(isset ($education_id))
			{
				global $wpdb;
				$sql2 = "SELECT name FROM $table_education_levels WHERE id= %d";
				$result2 = $wpdb->get_row($wpdb->prepare($sql2, $education_id), ARRAY_A);
				$education = "";
				$education = $result2['name'];
			}
			if(isset ($agent_id))
			{
				global $wpdb;
				$sql3 = "SELECT name, surname FROM $table_agents WHERE id= %d";
				$result3 = $wpdb->get_row($wpdb->prepare($sql3, $agent_id), ARRAY_A);
				$agent = $result3['name'] . " " . $result3['surname'];
			}
			if(isset ($country_id))
			{
				global $wpdb;
				$sql4 = "SELECT country_name FROM $table_countries WHERE id= %d";
				$result4 = $wpdb->get_row($wpdb->prepare($sql4, $country_id), ARRAY_A);
				$country = $result4['country_name'];
			}
			if(isset ($country_origin_id))
			{
				global $wpdb;
				$sql5 = "SELECT country_name FROM $table_countries WHERE id= %d";
				$result5 = $wpdb->get_row($wpdb->prepare($sql5, $country_origin_id), ARRAY_A);
				$country_origin = $result5['country_name'];
			}
			
			echo '<tr>
			      <td style="font-weight: bold;">Name</td>
			      <td>'.$name.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Surname</td>
			      <td>'.$surname.'</td>
			      </tr>
			      <tr>
			      <tr>
			      <td style="font-weight: bold;">Gender</td>
			      <td>'.$gender.'</td>
			      </tr>
			      <td style="font-weight: bold;">Email</td>
			      <td>'.$email.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Address</td>
			      <td>'.$address.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Town</td>
			      <td>'.$town.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Post Code</td>
			      <td>'.$postcode.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Country</td>
			      <td>'.$country.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Country of Origin</td>
			      <td>'.$country_origin.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Tel Land Line</td>
			      <td>'.$tel_land_line.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Tel Mobile</td>
			      <td>'.$tel_mobile.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Date of Birth</td>
			      <td>'.$date_of_birth.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Position</td>
			      <td>'.$position.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Passport No.</td>
			      <td>'.$passport_number.'</td>
			      </tr>
				  <tr>
			      <td style="font-weight: bold;">Years of Experience</td>
			      <td>'.$xp.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Education</td>
			      <td>'.$education.'</td>
			      </tr>
			      <tr>
			      <td style="font-weight: bold;">Agent</td>
			      <td>'.$agent.'</td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='cv_resume')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
			echo '<tr>
			      <td style="font-weight: bold;">CV/Resume</td>
			      <td><a href="'.$cvresume.'">CV/Resume</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='photo_id')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Identity Card</td>
			      <td><a href="'.$cvresume.'">Identity Card</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='passport')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
			echo '<tr>
			      <td style="font-weight: bold;">Passport</td>
			      <td><a href="'.$cvresume.'">Passport</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='driving_licence')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			$cnt = $wpdb->num_rows;
			if ($cnt < 1)
			{
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
			echo '<tr>
			      <td style="font-weight: bold;">Driving Licence</td>
			      <td><a href="'.$cvresume.'">Driving Licence</a></td>
			      </tr>';
			}
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='international_driving_permit')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			$cnt = $wpdb->num_rows;
			if ($cnt < 1)
			{
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">International Driving Permit</td>
			      <td><a href="'.$cvresume.'">International Driving Permit</a></td>
			      </tr>';
			}
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='driving_licence_part2')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			$cnt = $wpdb->num_rows;
			if ($cnt < 1)
			{
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Driving Licence 2nd Part</td>
			      <td><a href="'.$cvresume.'">Driving Licence 2nd Part</a></td>
			      </tr>';
			}
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate1')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Education Certificate 1</td>
			      <td><a href="'.$cvresume.'">Education Certificate 1</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate2')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Education Certificate 2</td>
			      <td><a href="'.$cvresume.'">Education Certificate 2</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate3')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			$cnt = $wpdb->num_rows;
			if ($cnt < 1)
			{
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Education Certificate 3</td>
			      <td><a href="'.$cvresume.'">Education Certificate 3</a></td>
			      </tr>';
			}
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate1w')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
			echo '<tr>
			      <td style="font-weight: bold;">Work Certificate 1</td>
			      <td><a href="'.$cvresume.'">Work Certificate 1</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate2w')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Work Certificate 2</td>
			      <td><a href="'.$cvresume.'">Work Certificate 2</a></td>
			      </tr>';
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='certificate3w')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			$cnt = $wpdb->num_rows;
			if ($cnt < 1)
			{
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
			echo '<tr>
			      <td style="font-weight: bold;">Work Certificate 3</td>
			      <td><a href="'.$cvresume.'">Work Certificate 3</a></td>
			      </tr>';
			}
			$sqltest = "SELECT url FROM $table_attachments WHERE attachment_category_id=(SELECT id FROM $table_attachment_categories WHERE name='police_conduct')";
			$resulttest = $wpdb->get_results($sqltest, ARRAY_A);
			foreach($resulttest as $arrr)
			{
				$cvresume = $arrr['url'];
			}
				echo '<tr>
			      <td style="font-weight: bold;">Police Conduct</td>
			      <td><a href="'.$cvresume.'">Police Conduct</a></td>
			      </tr>';
        echo '</table>';
        
		exit;
	}
			if (isset ($_POST['delete_application']))
			{
				global $wpdb;
				$sql = "SELECT * FROM $table_applications WHERE (id= %d)";
				$result = $wpdb->get_row($wpdb->prepare($sql, $_POST['delete_application']), ARRAY_A);
					$name = $result['name'];
					$surname = $result['surname'];
					$gender = $result['gender'];
					$email = $result['email'];
					$address = $result['address'];
					$town = $result['town'];
					$postcode = $result['postcode'];
					$tel_land_line = $result['tel_land_line'];
					$tel_mobile = $result['tel_mobile'];
					$passport_number = $result['passport_number'];
					$xp = $result['xp'];
					$skill = $result['skill'];
					$position_id = $result['position_id'];
					$education_id = $result['education'];
					$agent_id = $result['agent_id'];
					$date_of_birth = $result['date_of_birth'];
					$country_id = $result['country'];
					$country_origin_id = $result['country_origin'];
					$attachment_location = $result['attachments_location'];
					if(isset($result['position_other']))
					{
						$position = $result['position_other'];
						$position_other = ",'" .$result['position_other']. "'";
						$position_var = ",position_other";
					}
					else
					{
						$position_other = "";
						$position_var = "";
					}
				$prepare_variables = array($name,$surname,$gender,$email,$address,$town,$postcode,$country_id,$tel_land_line,$tel_mobile,$date_of_birth,$education_id,$position_id,$position_other,$skill,$country_origin_id,$xp,$passport_number,$agent_id,$attachment_location);
				$sql2 = "INSERT INTO $table_archive(name, surname, gender, email, address, town, postcode, country, tel_land_line, tel_mobile, date_of_birth, education, position_id, position_other, skill, country_origin, xp, passport_number, agent_id, attachments_location) VALUES(%s,%s,%s,%s,%s,%s,%s,%d,%d,%d,%s,%d,%d,%s,%s,%d,%d,%s,%d,%s)";
				$wpdb->query($wpdb->prepare($sql2, $prepare_variables));
				$sql3 = "DELETE FROM $table_applications WHERE (id= %d)";
				$wpdb->query($wpdb->prepare($sql3, $_POST['delete_application']));
			}
		echo '<h2>Applications</h2>
		      <table style="max-width:80%; border:0; padding: 10px;">
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
				      <td style="padding: 8px;">Archive Application</td>
			      </thead>
			      <tbody style="background-color: white; color: black;">';
				global $wpdb;
				$sql = "SELECT * FROM $table_applications";
				$result = $wpdb->get_results($sql, ARRAY_A);
				foreach($result as $row)
				{
					if(isset($row['position_id']))
					{
						$sql1 = "SELECT name FROM $table_positions WHERE id= %d";
						$result1 = $wpdb->get_row($wpdb->prepare($sql1, $row['position_id']), ARRAY_A);
							$position = $result1['name'];
					}
					else if(isset($row['position_other']))
					{
						$position = $row['position_other'];
					}
					if (isset($row['education']))
					{
						$sql2 = "SELECT name FROM $table_education_levels WHERE id= %d";
						$result2 = $wpdb->get_row($wpdb->prepare($sql2, $row['education']), ARRAY_A);
						$education = $result2['name'];
					}
					if (isset($row['agent_id']))
					{
						$sql3 = "SELECT name, surname FROM $table_agents WHERE id= %d";
						$result3 = $wpdb->get_row($wpdb->prepare($sql3, $row['agent_id']), ARRAY_A);
							$agent = $result3['name'] . " " . $result3['surname'];
					}
					if (isset ($row['country']))
					{
						$sql4 = "SELECT country_name FROM $table_countries WHERE id= %d";
						$result4 = $wpdb->get_row($wpdb->prepare($sql4, $row['country']), ARRAY_A);
							$country = $result4['country_name'];
					}
					if (isset ($row['country_origin']))
					{
						$sql5 = "SELECT country_name FROM $table_countries WHERE id= %d";
						$result5 = $wpdb->get_row($wpdb->prepare($sql5, $row['country_origin']), ARRAY_A);
							$country_origin = $result5['country_name'];
					}
					$date_of_birth = $row['date_of_birth'];
					$date_of_birth = new DateTime($date_of_birth);
    				$date_of_birth = $date_of_birth->format("d. m. Y");
					echo '<tr>
					      <td>
					      <form method="post">
					      <input type="hidden" name="submission" value="'.$row['id'].'">
					      <a href="#" onclick="this.parentNode.submit(); return false;">'.$row['id'].'</a>
					      </form>
					      </td>
					      <td>'.$row['name'].'</td>
					      <td>'.$row['surname'].'</td>
					      <td>'.$row['gender'].'</td>
					      <td>'.$row['email'].'</td>
					      <td>'.$row['address'].'</td>
					      <td>'.$row['town'].'</td>
					      <td>'.$row['postcode'].'</td>
					      <td>'.$country.'</td>
					      <td>'.$country_origin.'</td>
					      <td>'.$row['tel_land_line'].'</td>
					      <td>'.$row['tel_mobile'].'</td>
					      <td>'.$date_of_birth.'</td>
					      <td>'.strtoupper($position).'</td>
					      <td>'.$row['xp'].'</td>
					      <td>'.$row['passport_number'].'</td>
					      <td>'.$education.'</td>
					      <td>'.$agent.'</td>
					      <td><form method="post"><button type="submit" name="delete_application" value="'. $row['id'] .'">Archive</button></form></td>
					      </tr>';
				}
			echo '</tbody>
			  </table>
		  </div>';