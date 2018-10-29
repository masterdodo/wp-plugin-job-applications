<?php
/**
* @package JobApplicaions
*/
/*
Plugin name: Job Applications
Plugin URI: https://github.com/masterdodo/wp-plugin-job-applications
Description: This is a plugin that allows you to manage job applications.
Version: 1.0
Author: David Aristovnik
Author URI: https://aristovnik.com
Licence: GPLv3 or later
Text domain: wp-plugin-job-applications
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright (C) 2018  David Aristovnik
*/

defined('ABSPATH') or die('You don\t have access to this file!');

class wpja_JobApplications
{
    function __construct()
    {
        $this->wpja_create_custom_admin_menu();
    }

    protected function wpja_create_custom_admin_menu()
    {
        add_action('admin_menu', array($this, 'wpja_custom_admin_menu'));
    }

    function wpja_register()
    {
        add_action('wp_enqueue_scripts',array($this, 'wpja_enqueue'));
        add_action('admin_enqueue_scripts',array($this, 'wpja_enqueue'));
        add_action('template_redirect', array($this, 'wpja_submit_application'));
        add_shortcode('job_application_form', array($this, 'wpja_application_form'));
        add_shortcode('job_application_table_all', array($this, 'wpja_table_all'));
        add_shortcode('job_application_table_single', array($this, 'wpja_table_single'));
    }

    function wpja_activate()
    {
        $this->wpja_custom_admin_menu();
        $this->wpja_create_custom_db_tables();
        flush_rewrite_rules();
    }

    function wpja_deactivate()
    {
        flush_rewrite_rules();
    }

    public function wpja_custom_admin_menu()
    {
        add_menu_page( 'HR Setup', 'HR Setup', 'manage_options', 'hr-setup', array($this, 'wpja_admin_database'), 'dashicons-clipboard');
	    add_submenu_page( 'hr-setup', 'All Job Applications', 'All Job Applications', 'manage_options', 'hr-setup', array($this, 'wpja_admin_database' ));
        add_submenu_page( 'hr-setup', 'Manage Positions', 'Manage Positions', 'manage_options', 'hr-setup-positions', array($this, 'wpja_add_position') );
 	    add_submenu_page( 'hr-setup', 'Manage Agents', 'Manage Agents', 'manage_options', 'hr-setup-agents', array($this, 'wpja_add_agent') );
	    add_submenu_page( 'hr-setup', 'Manage Vehicles', 'Manage Vehicles', 'manage_options', 'hr-setup-vehicles', array($this,'wpja_add_vehicle') );
	    add_submenu_page( 'hr-setup', 'Export Applications', 'Export Applications', 'manage_options', 'hr-setup-export', array($this,'wpja_export_applications') );
	    add_submenu_page( 'hr-setup', 'Import Applications', 'Import Applications', 'manage_options', 'hr-setup-import', array($this, 'wpja_import_applications') );
	    add_submenu_page( 'hr-setup', 'Reports', 'Reports', 'manage_options', 'hr-setup-report', array($this, 'wpja_report') );
	    add_submenu_page( 'hr-setup', 'Archive', 'Archive', 'manage_options', 'hr-setup-archive', array($this, 'wpja_archive') );
    }

    function wpja_enqueue()
    {
        wp_enqueue_style('mypluginstyle', plugins_url('/assets/css/main.css',__FILE__));
        wp_enqueue_script('mypluginscript', plugins_url('/assets/js/main.js',__FILE__));
    }

    function wpja_create_custom_db_tables()
    {
        require_once 'plugin-functions/create_tables.php';
    }

    function wpja_admin_database()
    {
        global $wpdb;
        $table_applications = $wpdb->prefix . "job_applications";
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_agents = $wpdb->prefix . "job_applications_agents";
        $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        $table_attachments = $wpdb->prefix . "job_applications_attachments";
        $table_archive = $wpdb->prefix . "job_applications_archive";
        $table_attachment_categories = $wpdb->prefix . "job_applications_attachment_categories";
        require_once 'plugin-functions/admin_database.php';
    }

    function wpja_add_position()
    {
        global $wpdb;
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_settings = $wpdb->prefix . "job_applications_settings";
        require_once 'plugin-functions/add_position.php';
    }

    function wpja_add_agent()
    {
        global $wpdb;
        $table_agents = $wpdb->prefix . "job_applications_agents";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        require_once 'plugin-functions/add_agent.php';
    }

    function wpja_add_vehicle()
    {
        global $wpdb;
        $table_vehicles = $wpdb->prefix . "job_applications_vehicles";
        require_once 'plugin-functions/add_vehicle.php';
    }

    function wpja_archive()
    {
        global $wpdb;
        $table_archive = $wpdb->prefix . "job_applications_archive";
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_agents = $wpdb->prefix . "job_applications_agents";
        $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        require_once 'plugin-functions/archive.php';
    }

    function wpja_export_applications()
    {
        echo '<h2>Export Applications</h2>
              <p>Coming soon...</p>';
    }

    function wpja_import_applications()
    {
        echo '<h2>Import Applications</h2>
              <p>Coming soon...</p>';
    }

    function wpja_report()
    {
        echo '<h2>Report</h2>
              <p>Coming soon...</p>';
    }

    function wpja_application_form()
    {
        global $wpdb;
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        $table_agents = $wpdb->prefix . "job_applications_agents";
        $table_vehicles = $wpdb->prefix . "job_applications_vehicles";
        $this->wpja_enqueue();
        $plugin_url = plugin_dir_url(__FILE__);
        require_once 'frontend_files/application_form.php';
        return $string;
    }

    function wpja_submit_application()
    {
        if(isset ($_POST['submit-application']))
        {
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
            require_once 'plugin-functions/submit_application.php';
        }
    }

    function wpja_table_all()
    {
        global $wpdb;
        $table_applications = $wpdb->prefix . "job_applications";
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        require_once 'frontend_files/table_all.php';
    }
    function wpja_table_single($id = 0)
    {
        global $wpdb;
        $table_applications = $wpdb->prefix . "job_applications";
        $table_positions = $wpdb->prefix . "job_applications_positions";
        $table_education_levels = $wpdb->prefix . "job_applications_education_levels";
        $table_countries = $wpdb->prefix . "job_applications_countries";
        $position_id = $id['id'];
        require_once 'frontend_files/table_single.php';
    }
    
}

if(class_exists('wpja_JobApplications'))
{
    $jobApplications = new wpja_JobApplications();
    $jobApplications->wpja_register();
}

register_activation_hook(__FILE__,array($jobApplications,'wpja_activate'));

register_deactivation_hook(__FILE__,array($jobApplications,'wpja_deactivate'));

register_uninstall_hook( 'uninstall.php', 'wpja_uninstall' );