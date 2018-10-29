<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	echo '<div class="wrap">
		  <h2>Job Agents</h2><br />';
		  if( ! current_user_can('administrator'))
		{
			echo "Access denied.<br />You need to be an Administrator to access this file.";
			die;
		}
		if(isset($_POST['new_agent']))
		{
			if( ! check_admin_referer('wpja_new_agent', 'wpja_nonce_field_new_agent'))
			{
				echo "Error, authentication failed!";
				die;
			}
			$new_agent_name = sanitize_text_field($_POST['new_agent']);
			$new_agent_name = preg_replace('/[^A-Za-z\ -]/', '', $new_agent_name);
			if(strlen($new_agent_name) > 100)
			{
				$new_agent_name = substr($new_agent_name, 0, 100);
			}
			if(isset($_POST['new_agent2']))
			{
				$new_agent_surname = sanitize_text_field($_POST['new_agent2']);
				$new_agent_surname = preg_replace('/[^A-Za-z\ -]/', '', $new_agent_surname);
				if(strlen($new_agent_surname) > 100)
				{
					$new_agent_surname = substr($new_agent_surname, 0, 100);
				}
				if($new_agent_surname == NULL || $new_agent_surname == "")
				{
					$new_agent_surname = NULL;
				}
			}
			if(isset($_POST['country']))
			{
				$agent_country = sanitize_text_field($_POST['country']);
				$agent_country = preg_replace('/[^0-9]/', '', $agent_country);
			}
			global $wpdb;
			$prepare_variables = array($new_agent_name,$new_agent_surname,$agent_country);
			$sql = "INSERT INTO $table_agents(name, surname, country) VALUES(%s, %s, %d)";
			$wpdb->query($wpdb->prepare($sql, $prepare_variables));
		}
		if(isset($_POST['delete_agent']))
		{
			$delete_agent_id = sanitize_text_field($_POST['delete_agent']);
			$delete_agent_id = preg_replace('/[^0-9]/', '', $delete_agent_id);
			global $wpdb;
			$sql = "DELETE FROM $table_agents WHERE id= %d";
			$wpdb->query($wpdb->prepare($sql, $delete_agent_id));
		}
		echo '<form method="post">';
			wp_nonce_field('wpja_new_agent', 'wpja_nonce_field_new_agent');
		echo '<input type="text" name="new_agent" placeholder="Agent name/Company name" maxlength="100" style="width: 200px;" required autofocus><br />
		      <input type="text" name="new_agent2" placeholder="Agent surname (if a person)" maxlength="100" style="width: 200px;"><br />
		      <select name="country" class="dropdown-menu" required="" maxlength="74">
		      <option disabled="" selected="" value="">--choose country--</option>';
		global $wpdb;
		$sql = "SELECT * FROM $table_countries";
		$result = $wpdb->get_results($sql, ARRAY_A);
		foreach($result as $row)
		{
			echo "<option value=\"".esc_html($row['id'])."\">".esc_html($row['country_name'])."</option>";
		}
		echo '</select><br />
		      <button type="submit" name="submit">Insert</button>
              </form>
	      <br /><table style="max-width:80%; border:0; padding: 5px;">
		      <thead style="background-color: #4f79bc; color: white;">
			      <td>ID</td>
			      <td>NAME OF AGENT</td>
			      <td>COUNTRY</td>
			      <td>DELETE AGENT</td>
		      </thead>
		      <tbody style="background-color: white; color: #4f79bc;">';
			$sql = "SELECT * FROM $table_agents";
			$result = $wpdb->get_results($sql, ARRAY_A);
			foreach($result as $row)
			{
				$sqlagentcountry = "SELECT * FROM $table_countries WHERE id= %d";
				$resultagentcountry = $wpdb->get_results($wpdb->prepare($sqlagentcountry, $row['country']), ARRAY_A);
				foreach($resultagentcountry as $rowagentcountry)
				{
				$row['country'] = $rowagentcountry['country_code'];
				}
				echo '<tr>
				      <td style="padding: 8px;">'.esc_html($row['id']).'</td>
				      <td style="padding: 8px;">'.esc_html($row['name']).' '.esc_html($row['surname']).'</td>
				      <td>'.esc_html($row['country']).'</td>
				      <td style="padding: 8px;">
				      <form method="post">
				      <button type="submit" name="delete_agent" value="'.esc_html($row['id']).'" style="border:0; background-color: #4f79bc; color: white;">DELETE</button>
				      </form>
				      </td>
				      </tr>';
			}
		echo '</tbody>
	      </table>
	      </div>';