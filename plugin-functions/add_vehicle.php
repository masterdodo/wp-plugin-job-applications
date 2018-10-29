<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	if( ! current_user_can('administrator'))
	{
		echo "Access denied.<br />You need to be an Administrator to access this file.";
		die;
	}
	echo '<div class="wrap">
	      <h2>Vehicle Licences</h2><br />';
		if(isset($_POST['new_vehicle']))
		{
			if( ! check_admin_referer('wpja_new_vehicle', 'wpja_nonce_field_new_vehicle'))
		{
			echo "Error, authentication failed!";
			die;
		}
			$new_vehicle = sanitize_text_field($_POST['new_vehicle']);
			$new_vehicle = preg_replace('/[^A-Za-z\- _]/', '', $new_vehicle);
			global $wpdb;
			$sql = "INSERT INTO $table_vehicles(name) VALUES(UPPER(%s))";
			$wpdb->query($wpdb->prepare($sql, $new_vehicle));
		}
		if(isset($_POST['delete_vehicle']))
		{
			$delete_vehicle = sanitize_text_field($_POST['delete_vehicle']);
			$delete_vehicle = preg_replace('/[^0-9]/', '', $delete_vehicle);
			global $wpdb;
			$sql = "DELETE FROM $table_vehicles WHERE id= %d";
			$wpdb->query($wpdb->prepare($sql, $delete_vehicle));
		}
	echo '<form method="post">';
	wp_nonce_field('wpja_new_vehicle', 'wpja_nonce_field_new_vehicle');
		echo '<input type="text" name="new_vehicle" placeholder="Write a new Vehicle licence" style="width: 200px;" required autofocus><br />
		      <button type="submit" name="submit">Insert</button>
	      </form>
	      <br /><table style="max-width:80%; border:0; padding: 5px;">
		      <thead style="background-color: #4f79bc; color: white;">
			      <td>ID</td>
			      <td>NAME OF VEHICLE</td>
			      <td>DELETE VEHICLE</td>
		      </thead>
		      <tbody style="background-color: white; color: #4f79bc;">';
			global $wpdb;
			$sql = "SELECT * FROM $table_vehicles";
			$result = $wpdb->get_results($sql, ARRAY_A);
			foreach($result as $row)
			{
				echo '<tr>
				      <td style="padding: 8px;">'.esc_html($row['id']).'</td>
				      <td style="padding: 8px;">'.esc_html($row['name']).'</td>
				      <td style="padding: 8px;">
				      <form method="post">
				      <button type="submit" name="delete_vehicle" value="'.esc_html($row['id']).'" style="border:0; background-color: #4f79bc; color: white;">DELETE</button>
				      </form>
				      </td>
				      </tr>';
			}
		echo '</tbody>
	      </table>
	      </div>';