<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	echo '<div class="wrap">
		  <h2>Job Positions</h2><br />';
		  if( ! current_user_can('administrator'))
		{
			echo "Access denied.<br />You need to be an Administrator to access this file.";
			die;
		}
	if(isset($_POST['new_position']))
	{
		if( ! check_admin_referer('wpja_new_position', 'wpja_nonce_field_new_position'))
		{
			echo "Error, authentication failed!";
			die;
		}
		$new_position = sanitize_text_field($_POST['new_position']);
		$new_position = preg_replace('/[^A-Za-z\- ]/', '', $new_position);
		global $wpdb;
		$sql = "INSERT INTO $table_positions(name) VALUES(UPPER(%s))";
		$wpdb->query($wpdb->prepare($sql, $new_position));
		$position_id = $wpdb->insert_id;

		if((get_page_by_title( 'Find a Job' ) != NULL) && (get_page_by_title('Find Talent') != NULL))
		{
			$sql = "SELECT value FROM $table_settings WHERE name=%s";
			$result_findajob = $wpdb->get_row($wpdb->prepare($sql, 'findajob'), ARRAY_A);
			$result_findajob = $result_findajob['value'];
			$sql = "SELECT value FROM $table_settings WHERE name=%s";
			$result_findtalent = $wpdb->get_row($wpdb->prepare($sql, 'findtalent'), ARRAY_A);
			$result_findtalent = $result_findtalent['value'];
			$PageGuid = site_url() . "/" . $new_position;
			$my_post  = array( 'post_title'     => $new_position,
								  'post_type'      => 'page',
								  'post_name'      => $new_position,
								  'post_content'   => 'Put content here ...<br /> [job_application_form]',
								  'post_status'    => 'publish',
								  'comment_status' => 'closed',
								  'ping_status'    => 'closed',
								  'post_author'    => 1,
								  'menu_order'     => 0,
								  'post_parent'	=> $result_findajob,
								  'guid'           => $PageGuid );
	
			$PageID = wp_insert_post( $my_post, FALSE );
			
			$PageGuid = site_url() . "/a/" . $new_position;
			$my_post  = array( 'post_title'     => $new_position,
							   'post_type'      => 'page',
							   'post_name'      => $new_position,
							   'post_content'   => '[job_application_table_single id='.$position_id.']',
							   'post_status'    => 'publish',
							   'comment_status' => 'closed',
							   'ping_status'    => 'closed',
							   'post_author'    => 1,
							   'menu_order'     => 0,
							   'post_parent'	=> $result_findtalent,
							   'guid'           => $PageGuid );
	
			$PageID = wp_insert_post( $my_post, FALSE );
		}
		else if((get_page_by_title( 'Find a Job' ) == NULL) && (get_page_by_title('Find Talent') == NULL))
		{
			$PageGuid = site_url() . "/Find a Job/";
			$my_post  = array( 'post_title'     => 'Find a Job',
							   'post_type'      => 'page',
							   'post_name'      => 'Find a Job',
							   'post_content'   => 'Put content here...<br /> [job_application_form]',
							   'post_status'    => 'publish',
							   'comment_status' => 'closed',
							   'ping_status'    => 'closed',
							   'post_author'    => 1,
							   'menu_order'     => 0,
							   'post_parent'	=> 0,
							   'guid'           => $PageGuid );
	
			$PageID = wp_insert_post($my_post, FALSE);
			$page_findajob = get_page_by_title('Find a Job');
			$findajobID = $page_findajob->ID;
			$sql = "UPDATE $table_settings SET value = $findajobID WHERE name = %s";
			$wpdb->query($wpdb->prepare($sql, 'findajob'));
	
			$PageGuid = site_url() . "/Find Talent/";
			$my_post  = array( 'post_title'     => 'Find Talent',
							   'post_type'      => 'page',
							   'post_name'      => 'Find Talent',
							   'post_content'   => '[job_application_table_all]',
							   'post_status'    => 'publish',
							   'comment_status' => 'closed',
							   'ping_status'    => 'closed',
							   'post_author'    => 1,
							   'menu_order'     => 0,
							   'post_parent'	=> 0,
							   'guid'           => $PageGuid );
	
			$PageID = wp_insert_post($my_post, FALSE);
			$page_findtalent = get_page_by_title('Find Talent');
			$findtalentID = $page_findtalent->ID;
			$sql = "UPDATE $table_settings SET value = $findtalentID WHERE name = %s";
			$wpdb->query($wpdb->prepare($sql, 'findtalent'));
			//-----------------//
			global $wpdb;
			$sql = "SELECT value FROM $table_settings WHERE name= %s";
			$result_findajob = $wpdb->get_row($wpdb->prepare($sql, 'findajob'), ARRAY_A);
			$IDfindajob = $result_findajob['value'];
			$sql = "SELECT value FROM $table_settings WHERE name= %s";
			$result_findtalent = $wpdb->get_row($wpdb->prepare($sql, 'findtalent'), ARRAY_A);
			$IDfindtalent = $result_findtalent['value'];
			$PageGuid = site_url() . "/" . $new_position;
			$my_post  = array( 'post_title'     => $new_position,
								  'post_type'      => 'page',
								  'post_name'      => $new_position,
								  'post_content'   => 'Put content here ...<br /> [job_application_form]',
								  'post_status'    => 'publish',
								  'comment_status' => 'closed',
								  'ping_status'    => 'closed',
								  'post_author'    => 1,
								  'menu_order'     => 0,
								  'post_parent'	=> $IDfindajob,
								  'guid'           => $PageGuid );
	
			$PageID = wp_insert_post( $my_post, FALSE );
			
			$PageGuid = site_url() . "/a/" . $new_position;
			$my_post  = array( 'post_title'     => $new_position,
							   'post_type'      => 'page',
							   'post_name'      => $new_position,
							   'post_content'   => '[job_application_table_single id='.$position_id.']',
							   'post_status'    => 'publish',
							   'comment_status' => 'closed',
							   'ping_status'    => 'closed',
							   'post_author'    => 1,
							   'menu_order'     => 0,
							   'post_parent'	=> $IDfindtalent,
							   'guid'           => $PageGuid );
	
			$PageID = wp_insert_post( $my_post, FALSE );
		}
	}

	if(isset($_POST['delete_position']))
	{
		$delete_position = sanitize_text_field($_POST['delete_position']);
		global $wpdb;
		$sql = "DELETE FROM $table_positions WHERE name= %s";
		$wpdb->query($wpdb->prepare($sql, $delete_position));
		$page = get_page_by_title($delete_position);
		wp_delete_post($page->ID);
		$page = get_page_by_title($delete_position);
		wp_delete_post($page->ID);
	}
	if( ! current_user_can('administrator'))
	{
		echo "Access denied.<br />You need to be an Administrator to access this file.";
		die;
	}
	echo '<form method="post">';
	wp_nonce_field('wpja_new_position', 'wpja_nonce_field_new_position');
		echo '<input type="text" name="new_position" placeholder="Write a new position" required autofocus>
		      <button type="submit" name="submit">Insert</button>
	      </form>
	      <br /><table style="max-width:80%; border:0; padding: 5px;">
		      <thead style="background-color: #4f79bc; color: white;">
			      <td style="padding: 8px;">ID</td>
			      <td style="padding: 8px;">NAME OF POSITION</td>
			      <td style="padding: 8px;">DELETE POSITION</td>
		      </thead>
			  <tbody style="background-color: white; color: #4f79bc;">';
			
			global $wpdb;
			$sql = "SELECT * FROM $table_positions";
			$result = $wpdb->get_results($sql, ARRAY_A);
			foreach($result as $row)
			{
				echo "<tr>";
				echo "<td style=\"padding: 8px;\">".esc_html($row['id'])."</td>";
				echo "<td style=\"padding: 8px;\">".esc_html($row['name'])."</td>";
				echo "<td style=\"padding: 8px;\">";
				echo "<form method=\"post\">";
				echo "<button type=\"submit\" name=\"delete_position\" value=\"".esc_html($row['name'])."\" style=\"border:0; background-color: #4f79bc; color: white;\">DELETE</button>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			}
		echo '</tbody>
	      </table>
	      </div>';