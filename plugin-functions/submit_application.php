<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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

    $redirect_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?err=1";
    $error_bool = 0;

        //Name validation
        $name = sanitize_text_field($_POST['sname']);
        $name = clean_string_fields($name, 100);
        if (preg_match('~[0-9]~', $name))
        {
            $name = preg_replace('/[0-9]+/', '', $name);
        }
        //Surname validation
        $surname = sanitize_text_field($_POST['surname']);
        $surname = clean_string_fields($surname, 100);
        if (preg_match('~[0-9]~', $surname))
        {
            $surname = preg_replace('/[0-9]+/', '', $surname);
        }
        //Passport number validation
        $passport_number = sanitize_text_field($_POST['passport_number']);
        $passport_number = clean_string_fields($passport_number, 15);
        //Email validation
        $email = sanitize_email($_POST['email']);
        if( ! filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            //wp_redirect($redirect_url);
            echo "8";
            exit;
        }
        //Gender validation
        $gender = sanitize_text_field($_POST['gender']);
        //Address validation
        $address = sanitize_text_field($_POST['address']);
        if(strlen($address) > 100)
        {
            $address = substr($address, 0, 100);
        }
        //Town validation
        $town = sanitize_text_field($_POST['town']);
        if(strlen($town) > 100)
        {
            $town = substr($town, 0, 100);
        }
        //Postcode validation
        $postcode = sanitize_text_field($_POST['postcode']);
        $postcode = clean_string_fields($postcode, 50);
        //Country ID validation
        $country_id = intval($_POST['country']);
        if($country_id == 0)
        {
            $_SESSION['error_messages'][] = 'Country error. Try again!';
            //wp_redirect($redirect_url);
            echo "7";
            exit;
        }
        //Country of Origin ID validation
        $country_origin_id = intval($_POST['country_origin']);
        if($country_origin_id == 0)
        {
            $_SESSION['error_messages'][] = 'Country of origin error. Try again!';
            //wp_redirect($redirect_url);
            echo "6";
            exit;
        }
        //Telephone land line validation
        if(isset($_POST['tel_land_line']))
        {
            $tel_land_line = intval($_POST['tel_land_line']);
            $tel_land_line = clean_string_fields($tel_land_line, 50);
        }
        else
        {
            $tel_land_line = 0;
        }
        //Telephone mobile validation
        $tel_mobile = intval($_POST['tel_mobile']);
        $tel_mobile = clean_string_fields($tel_mobile, 50);
        //Date of birth validation
        $date_of_birth = sanitize_text_field($_POST['date_of_birth']);
        $date_of_birth = preg_replace('/[^0-9\- :]/', '', $date_of_birth);
        //Position ID validation
        $whichSQL = 0;
        if(isset($_POST['position']))
        {
            $whichSQL = 1;
            $position_id = intval($_POST['position']);
            if($position_id == 0)
            {
                $_SESSION['error_messages'][] = 'Position error. Try again!';
                //wp_redirect($redirect_url);
                echo "5";
                exit;
            }
        }
        //Other position validation
        if(isset($_POST['position_other']) && $_POST['position_other'] != '')
        {
            $whichSQL = 2;
            $position_other = sanitize_text_field($_POST['position_other']);
            $position_other = preg_replace('/[^A-Za-z\čćžšđ]/', '', $position_other);
        }
        if($whichSQL == 0)
        {
            $_SESSION['error_messages'][] = 'Form error. Try again!';
            //wp_redirect($redirect_url);
            echo "4";
            exit;
        }
        //Skill validation
        if(isset($_POST['skill']))
        {
            $skill = sanitize_text_field($_POST['skill']);
            $skill = preg_replace('/[^A-Za-z0-9\čćžšđ.-@, ]/', '', $skill);
        }
        else
        {
            $skill = '/';
        }
        //Education ID validation
        $education_id = intval($_POST['education']);
        if($education_id == 0)
        {
            $_SESSION['error_messages'][] = 'Education level error. Try again!';
            //wp_redirect($redirect_url);
            echo "3";
            exit;
        }
        //Experience validation
        $experience = intval($_POST['xp']);
        $experience = preg_replace('/[^0-9]/', '', $experience);
        if(strlen($experience) > 2 && $experience != 100)
        {
            $experience = substr($experience, 0, 2);
        }
        //Agent ID validation
        $agent_id = intval($_POST['agent']);
        if($agent_id == 0)
        {
            $_SESSION['error_messages'][] = 'Agent selection error. Try again!';
            //wp_redirect($redirect_url);
            echo "2";
            exit;
        }

    function clean_string_fields($string,$limit)
    {
        if (strlen($string) > $limit)
        {
            $string = substr($string, 0, $limit);
        }
        $string = preg_replace('/[^A-Za-z0-9\-čćžšđ ]/', '', $string);

        return $string;
    }

    global $wpdb;
    $sql_country = "SELECT * FROM $table_countries";
    $result_country = $wpdb->get_results($sql_country, ARRAY_A);
    $count = 0;
    foreach($result_country as $row_country)
    {
    	if ($country_id == $row_country['country_name'])
    	{
            $count++;
        }
    	if ($country_origin_id == $row_country['country_name'])
    	{
            $count++;
        }
    }

    /*if($count == 0 || $count == 1)
    {
        echo "1";
        $_SESSION['error_messages'][] = 'Form error. Try again!';
        //wp_redirect($redirect_url);
        exit;
    }*/

    $count = 0;

    if($whichSQL == 1)
    {
        echo "123";
        $sql_position = "SELECT name FROM $table_positions WHERE id=%d";
        $sql_position = $wpdb->prepare($sql_position, $position_id);
    	$result_position = $wpdb->get_row($sql_position, ARRAY_A);
    	$position_name = $result_position['name'];
        $my_plugin = WP_PLUGIN_DIR . '/job-applications/';
        $dir = $my_plugin . "attachments/" . $position_name . "/" . $name . "_" . $surname . "/";
        $url = $plugin_url . "attachments/" . $position_name . "/" . $name . "_" . $surname . "/";
    	if (!file_exists($dir))
    	{
    		mkdir($dir, 0777, true);
    	}
    	$submiter_name = $name;
        $submiter_surname = $surname;
        $submiter_email = $email;
        global $wpdb;
        $sql_prepare_values = array($name, $surname, $gender, $email, $address, $town, $postcode, $country_id, $tel_mobile, $tel_land_line, $date_of_birth, $position_id, $position_id, $country_origin_id, $experience, $passport_number, $agent_id, $skill, $url);
    	$sql = "INSERT INTO $table_applications(name, surname, gender, email, address, town, postcode, country, tel_mobile, tel_land_line, date_of_birth, position_id, education, country_origin, xp, passport_number, agent_id, skill, attachments_location) 
    	VALUES(%s,%s,%s,%s,%s,%s,%s,%d,%d,%d,%s,%d,%d,%d,%d,%s,%d,%s,%s)";
        $result = $wpdb->query($wpdb->prepare($sql, $sql_prepare_values));
        $submiter_id = $wpdb->insert_id;

    }
    else if ($whichSQL == 2)
    {
        echo "456";
        $my_plugin = WP_PLUGIN_DIR . '/job-applications/';
        $dir = $my_plugin . "attachments/" . $position_other . "/" . $name . "_" . $surname . "/";
        $url = $plugin_url . "attachments/" . $position_other . "/" . $name . "_" . $surname . "/";
    	if (!file_exists($dir))
    	{
    		mkdir($dir, 0777, true);
    	}
        $submiter_name = $name;
        $submiter_surname = $surname;
        $submiter_email = $email;
        global $wpdb;
        $sql_prepare_values = array($name, $surname, $gender, $email, $address, $town, $postcode, $country_id, $tel_mobile, $tel_land_line, $date_of_birth, $position_other, $position_id, $country_origin_id, $experience, $passport_number, $agent_id, $skill, $url);
    	$sql = "INSERT INTO $table_applications(name, surname, gender, email, address, town, postcode, country, tel_mobile, tel_land_line, date_of_birth, position_other, education, country_origin, xp, passport_number, agent_id, skill, attachments_location) 
    	VALUES(%s,%s,%s,%s,%s,%s,%s,%d,%d,%d,%s,%s,%d,%d,%d,%s,%d,%s,%s)";
        $result = $wpdb->query($wpdb->prepare($sql, $sql_prepare_values));
        $submiter_id = $wpdb->insert_id;
    }
    else
    {
        //wp_redirect($redirect_url);
        exit;
    }

    $idid = $submiter_id;

    $sqllicence = "SELECT * FROM $table_driving_licences";
    $resultlicence = $wpdb->get_results($sqllicence, ARRAY_A);
    $count = 1;
    foreach($resultlicence as $rowlicence)
    {
    	$string = "driving_licence".$count."a";
    	if (isset ($_POST[$string]) && $_POST[$string] != '')
    	{
            $sql_prepare_values = array($idid, $rowlicence['id']);
    		$sqldrivinglicence = "INSERT INTO $table_applications_driving_licences(application_id, driving_licence_id) VALUES(%d,%d)";
    		$resultdrivinglicence = $wpdb->query($wpdb->prepare($sqldrivinglicence, $sql_prepare_values));
    	}
    	$count++;
    }

    for ($i = 1; isset ($_POST['vehicle' . $i . 'a']); $i++)
    {
    	if ($_POST['vehicle' . $i . 'a'] != '')
    	{
            $sql_prepare_values = array($idid, $_POST['vehicle' . $i . 'a']);
    	    $sqlquery = "INSERT INTO $table_applications_vehicles(application_id, vehicle_id) VALUES(%d,%d)";
    	    $resultquery = $wpdb->query($wpdb->prepare($sqlquery, $sql_prepare_values));
    	}
    }
    if (isset ($_FILES['cv_resume']))
    {
        $target_file = $dir . "cv_resume." . pathinfo($_FILES['cv_resume']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "cv_resume." . pathinfo($_FILES['cv_resume']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='cv_resume'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["cv_resume"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['photo_id']))
    {
        $target_file = $dir . "photo_id." . pathinfo($_FILES['photo_id']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "photo_id." . pathinfo($_FILES['photo_id']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='photo_id'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["photo_id"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['passport']))
    {
        $target_file = $dir . "passport." . pathinfo($_FILES['passport']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "passport." . pathinfo($_FILES['passport']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='passport'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['driving_licence']))
    {
        $target_file = $dir . "driving_licence." . pathinfo($_FILES['driving_licence']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "driving_licence." . pathinfo($_FILES['driving_licence']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='driving_licence'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["driving_licence"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['international_driving_permit']))
    {
        $target_file = $dir . "international_driving_permit." . pathinfo($_FILES['international_driving_permit']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "international_driving_permit." . pathinfo($_FILES['international_driving_permit']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='international_driving_permit'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["international_driving_permit"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['driving_licence_part2']))
    {
        $target_file = $dir . "driving_licence_part2." . pathinfo($_FILES['driving_licence_part2']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "driving_licence_part2." . pathinfo($_FILES['driving_licence_part2']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='driving_licence_part2'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["driving_licence_part2"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['certificate1']))
    {
        $target_file = $dir . "certificate1." . pathinfo($_FILES['certificate1']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate1." . pathinfo($_FILES['certificate1']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate1'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate1"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['certificate2']))
    {
        $target_file = $dir . "certificate2." . pathinfo($_FILES['certificate2']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate2." . pathinfo($_FILES['certificate2']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate2'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate2"]["tmp_name"], $target_file);
    }

    if (isset ($_FILES['certificate3']))
    {
        $target_file = $dir . "certificate3." . pathinfo($_FILES['certificate3']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate3." . pathinfo($_FILES['certificate3']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate3'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate3"]["tmp_name"], $target_file);
    }
    if (isset ($_FILES['police_conduct']))
    {
        $target_file = $dir . "police_conduct." . pathinfo($_FILES['police_conduct']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "police_conduct." . pathinfo($_FILES['police_conduct']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='police_conduct'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["police_conduct"]["tmp_name"], $target_file);
    }

    if (isset ($_FILES['certificate1w']))
    {
        $target_file = $dir . "certificate1w." . pathinfo($_FILES['certificate1w']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate1w." . pathinfo($_FILES['certificate1w']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate1w'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate1w"]["tmp_name"], $target_file);
    }

    if (isset ($_FILES['certificate2w']))
    {
        $target_file = $dir . "certificate2w." . pathinfo($_FILES['certificate2w']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate2w." . pathinfo($_FILES['certificate2w']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate2w'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate2w"]["tmp_name"], $target_file);
    }

    if (isset ($_FILES['certificate3w']))
    {
        $target_file = $dir . "certificate3w." . pathinfo($_FILES['certificate3w']['name'],PATHINFO_EXTENSION);
        $target_url = $url . "certificate3w." . pathinfo($_FILES['certificate3w']['name'],PATHINFO_EXTENSION);
        $sql_prepare_values = array($target_url, $idid);
        $sqlfiles = "INSERT INTO $table_attachments(url, application_id, attachment_category_id) VALUES('%s',%d, (SELECT id FROM $table_attachment_categories WHERE name='certificate3w'))";
        $resultfiles = $wpdb->query($wpdb->prepare($sqlfiles, $sql_prepare_values));
        move_uploaded_file($_FILES["certificate3w"]["tmp_name"], $target_file);
    }

    $to = get_option('admin_email');
    $subject = "WP-Alert: New Application";
    $headers = 'From: '. $submiter_email . "\r\n" .
    'Reply-To: ' . $submiter_email . "\r\n";
    $message = "WP-MaltaRecruiting Alert \r\n \r\n
                New application is waiting for you.\r\n
                Name:$submiter_name \r\n
                Surname:$submiter_surname \r\n
                Email:$submiter_email \r\n
                You can find it under an ID number: $submiter_id";
    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
    if($sent)
    {
        //Email sent.
    }
    else
    {
        //Email failed to be sent.
    }