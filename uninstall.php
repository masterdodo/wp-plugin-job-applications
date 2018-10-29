<?php
    //defined ( 'WP_UNINSTALL_PLUGIN' ) or die();
function wpja_uninstall()
{
    
    $myfile = fopen("../output.txt", "w") or die("Unable to open file!");
    fwrite($myfile, "Test");
    fclose($myfile);

    global $wpdb;

    $table_settings = $wpdb->prefix . "job_applications_settings";
    //Get 'Find a Job' and 'Find Talent' page IDs
    $sql = "SELECT value FROM $table_settings WHERE name=%s";
	$result_findajob = $wpdb->get_row($wpdb->prepare($sql, 'findajob'), ARRAY_A);
	$result_findajob = $result_findajob['value'];
	$sql = "SELECT value FROM $table_settings WHERE name=%s";
	$result_findtalent = $wpdb->get_row($wpdb->prepare($sql, 'findtalent'), ARRAY_A);
	$result_findtalent = $result_findtalent['value'];
    //Delete all Find a Job pages
    $args = array( 
        'post_parent' => $result_findajob,
        'post_type' => 'page'
    );
    $posts = get_posts( $args );

    if (is_array($posts) && count($posts) > 0)
    {
        foreach($posts as $post)
        {
            wp_delete_post($post->ID, true);
        }
    }
    wp_delete_post($result_findajob, true);
    //Delete all Find Talent pages
    $args = array( 
        'post_parent' => $result_findtalent,
        'post_type' => 'page'
    );
    $posts = get_posts( $args );

    if (is_array($posts) && count($posts) > 0)
    {
        foreach($posts as $post)
        {
            wp_delete_post($post->ID, true);
        }
    }
    wp_delete_post($result_findtalent, true);

    //Clear DB data

    global $wpdb;

    $table_applications = $wpdb->prefix . "job_applications";
    $table_positions = $wpdb->prefix . "job_applications_positions";
    $table_agents = $wpdb->prefix . "job_applications_agents";
    $table_countries = $wpdb->prefix . "job_applications_countries";
    $table_vehicles = $wpdb->prefix . "job_applications_vehicles";
    $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
    $table_attachments = $wpdb->prefix . "job_applications_attachments";
    $table_driving_licences = $wpdb->prefix . "job_applications_driving_licences";
    $table_applications_attachments = $wpdb->prefix . "job_applications_application_attachments";
    $table_applications_driving_licences = $wpdb->prefix . "job_applications_application_driving_licences";
    $table_applications_vehicles = $wpdb->prefix . "job_applications_application_vehicles";
    $table_archive = $wpdb->prefix . "job_applications_archive";
    $table_attachment_categories = $wpdb->prefix . "job_applications_attachment_categories";
    $table_settings = $wpdb->prefix . "job_applications_settings";

    $sql = "DROP TABLE IF EXISTS $table_applications";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_positions";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_agents";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_countries";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_vehicles";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_education_levels";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_attachments";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_driving_licences";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_applications_attachments";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_applications_driving_licences";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_applications_vehicles";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_archive";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_attachment_categories";
    $wpdb->query($sql);

    $sql = "DROP TABLE IF EXISTS $table_settings";
    $wpdb->query($sql);
}