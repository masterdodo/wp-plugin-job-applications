<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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

    $charset_collate = $wpdb->get_charset_collate();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql_applications = "CREATE TABLE IF NOT EXISTS $table_applications (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        surname varchar(100) NOT NULL,
        gender varchar(10) NOT NULL,
        email varchar(100) NOT NULL,
        address varchar(100) NOT NULL,
        town varchar(100) NOT NULL,
        postcode varchar(100) NOT NULL,
        country int NOT NULL,
        tel_land_line int,
        tel_mobile int NOT NULL,
        date_of_birth timestamp NOT NULL,
        education int NOT NULL,
        position_id int,
        position_other varchar(100),
        skill text,
        country_origin int NOT NULL,
        xp int NOT NULL,
        passport_number varchar(100) NOT NULL,
        agent_id int,
        attachments_location varchar(200) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql_applications);

    $sql_positions = "CREATE TABLE IF NOT EXISTS $table_positions (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_positions);

    $sql_agents = "CREATE TABLE IF NOT EXISTS $table_agents(
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        surname varchar(100) NOT NULL,
        country int NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_agents);

    $sql_countries = "CREATE TABLE IF NOT EXISTS $table_countries (
        id int(11) NOT NULL AUTO_INCREMENT,
        country_code varchar(2) NOT NULL,
        country_name varchar(100) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_countries);

    $sql_vehicles = "CREATE TABLE IF NOT EXISTS $table_vehicles (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_vehicles);

    $sql_education_levels = "CREATE TABLE IF NOT EXISTS $table_education_levels (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_education_levels);

    $sql_attachments = "CREATE TABLE IF NOT EXISTS $table_attachments (
        id int(11) NOT NULL AUTO_INCREMENT,
        url text NOT NULL,
        application_id int(11) NOT NULL,
        attachment_category_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_attachments);

    $sql_driving_licences = "CREATE TABLE IF NOT EXISTS $table_driving_licences (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_driving_licences);

    $sql_applications_attachments = "CREATE TABLE IF NOT EXISTS $table_applications_attachments (
        id int(11) NOT NULL AUTO_INCREMENT,
        url text NOT NULL,
        application_id int(11) NOT NULL,
        attachment_category_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_applications_attachments);

    $sql_applications_driving_licences = "CREATE TABLE IF NOT EXISTS $table_applications_driving_licences (
        id int(11) NOT NULL AUTO_INCREMENT,
        application_id int(11) NOT NULL,
        driving_licence_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_applications_driving_licences);

    $sql_applications_vehicles = "CREATE TABLE IF NOT EXISTS $table_applications_vehicles (
        id int(11) NOT NULL AUTO_INCREMENT,
        application_id int(11) NOT NULL,
        vehicle_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_applications_vehicles);

    $sql_archive = "CREATE TABLE IF NOT EXISTS $table_archive (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        surname varchar(100) NOT NULL,
        gender varchar(10) NOT NULL,
        email varchar(100) NOT NULL,
        address varchar(100) NOT NULL,
        town varchar(100) NOT NULL,
        postcode varchar(100) NOT NULL,
        country int NOT NULL,
        tel_land_line int,
        tel_mobile int NOT NULL,
        date_of_birth timestamp NOT NULL,
        education int NOT NULL,
        position_id int,
        position_other varchar(100),
        skill text,
        country_origin int NOT NULL,
        xp int NOT NULL,
        passport_number varchar(100) NOT NULL,
        agent_id int NOT NULL,
        attachments_location varchar(200) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql_archive);

    $sql_attachment_categories = "CREATE TABLE IF NOT EXISTS $table_attachment_categories (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(50) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_attachment_categories);

    $sql_settings = "CREATE TABLE IF NOT EXISTS $table_settings (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(50) NOT NULL UNIQUE,
        value varchar(50) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql_settings);

    include 'initial_queries.php';