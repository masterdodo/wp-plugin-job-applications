<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(isset ($_POST['submit_application']))
{
      $my_plugin = WP_PLUGIN_DIR . '/job-applications';
      if(is_dir($my_plugin))
      {
            require_once $my_plugin . '/plugin-functions/submit_application.php';
      }
}

$string = '<div >
      <form id="wpja-application-form" action="" method="post" enctype="multipart/form-data">';
      if(isset($_GET['err']))
      {
            $string .= '<pre>' . var_dump($_SESSION['error_messages']) . '</pre>';
      }
$string .= '<div id="wpja-identification">
      <p><b>IDENTIFICATION</b></p>
      <label for="sname">Name*</label>
      <input class="wpja-input" id="sname" required type="text" name="sname" maxlength="100">
      <label for="surname">Surname*</label>
      <input class="wpja-input" id="surname" required type="text" name="surname" maxlength="100">
      <label for="passport_number">Passport number*</label>
      <input class="wpja-input" id="passport_number" required type="text" name="passport_number" maxlength="100">
      <label for="email">Email*</label>
      <input class="wpja-input" id="email" required type="email" name="email" maxlength="100">
      </div>
      <div id="wpja-personal">
      <p><b>PERSONAL INFORMATION</b></p>
      <label>Gender*</label>
      <input class="wpja-width-reset" checked type="radio" name="gender" value="male"> Male <input class="wpja-width-reset" type="radio" name="gender" value="female"> Female<br />
      <label for="address">Address*</label>
      <input class="wpja-input" id="address" type="text" name="address" maxlength="100" required>
      <label for="town">Town*</label>
      <input class="wpja-input" id="town" required type="text" name="town" maxlength="100">
      <label for="postcode">Postcode*</label>
      <input class="wpja-input" id="postcode" required type="text" name="postcode" maxlength="16">
      <label for="country">Country*</label>
      <select class="wpja-input" id="country" name="country" class="dropdown-menu" required>
      <option disabled selected value="">--choose country--</option>';
global $wpdb;
$sql = "SELECT * FROM $table_countries";
$result = $wpdb->get_results($sql, ARRAY_A);
foreach($result as $row)
{
$string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['country_name']).'</option>';
}
$string .= '</select>
      <label for="country_origin">Country of Origin*</label>
      <select class="wpja-input" id="country_origin" name="country_origin" class="dropdown-menu" maxlength="74" required>
      <option disabled selected value="">--choose country of origin--</option>';
global $wpdb;
$sql = "SELECT * FROM $table_countries";
$result = $wpdb->get_results($sql, ARRAY_A);
foreach($result as $row)
{
$string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['country_name']).'</option>';
}
$string .= '</select><br />
      <label for="tel_land_line">Tel Land Line</label>
      <input class="wpja-input" id="tel_land_line" type="number" name="tel_land_line" placeholder="example" maxlength="20">
      <label for="tel_mobile">Tel Mobile*</label>
      <input class="wpja-input" id="tel_mobile" required type="number" name="tel_mobile" placeholder="0038641285906" maxlength="20">
      <label for="date_of_birth">Date of Birth*</label>
      <input class="wpja-input" id="date_of_birth" required type="date" name="date_of_birth" maxlength="10">
      </div>
      <div id="wpja-work">
      <p><b>WORK</b></p>
      <label for="position">Position applying for: *</label>
      <select class="wpja-input" id="position" name="position" class="dropdown-menu" maxlength="100">
      <option disabled selected value="">--choose position--</option>';
global $wpdb;
$sql = "SELECT * FROM $table_positions";
$result = $wpdb->get_results($sql, ARRAY_A);
foreach($result as $row)
{
$string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['name']).'</option>';
}
$string .= '</select><br />
      ...or write your own position:<br />
      <input class="wpja-input" id="position_other" type="text" name="position_other" maxlength="100">
      <label for="skill">Skill: </label>
      <textarea id="skill" name="skill"></textarea>
      <br /><label for="education">Highest education level: *</label>
      <select class="wpja-input" id="education" name="education" class="dropdown-menu" required maxlength="100">
      <option disabled selected value="">--choose education level--</option>';
global $wpdb;
$sql = "SELECT * FROM $table_education_levels ORDER BY id";
$result = $wpdb->get_results($sql, ARRAY_A);
foreach($result as $row)
{
$string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['name']).'</option>';
}
$string .= '</select><br />
      <br /><label for="xp">Years of experience: (min 3 years)*</label>
      <input class="wpja-input" id="xp" required type="number" min="3" max="100" name="xp">
      <label for="agent">Agent: *</label>
      <select class="wpja-input" id="agent" name="agent" class="dropdown-menu" required maxlength="274">
      <option disabled selected value="">--none--</option>';
global $wpdb;
$sql = "SELECT * FROM $table_agents ORDER BY id";
$result = $wpdb->get_results($sql, ARRAY_A);
foreach($result as $row)
{
global $wpdb;
$sqlcountry = "SELECT * FROM $table_countries WHERE (id= %d)";
$resultcountry = $wpdb->get_row($wpdb->prepare($sqlcountry, $row['country']), ARRAY_A);
$string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['name']).' '.esc_html($row['surname']).', '.esc_html($resultcountry['country_name']).'</option>';
}
$string .= '</select><br />
      </div>';
if (true)
{
      $string .= '<div id="wpja-driving_licence_div">
            <p><b>DRIVING LICENCES</b></p>
            <div id="vehicles">
            <label for="vehicle">Driving Licence (vehicle): </label>
            <select class="wpja-input" id="vehicle" name="vehicle1a" class="dropdown-menu" maxlength="100">
            <option selected value="">--choose a vehicle licence--</option>';
      $sql = "SELECT * FROM $table_vehicles";
      $result = $wpdb->get_results($sql, ARRAY_A);
      foreach($result as $row)
      {
            $string .= '<option value="'.esc_html($row['id']).'">'.esc_html($row['name']).'</option>';
      }
      $string .= '</select><br />
            </div>
            <div id="driving_categories">
            <button id="wpja-addVehicleButton" type="button" onclick="AddVehicle()">Add another vehicle</button><br />
            <label>Driving licence categories: </label>
            AM<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence1a" value="1"> 
            A1<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence2a" value="2"> 
            A2<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence3a" value="3"> 
            A<input  class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence4a" value="4"> 
            B<input  class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence5a" value="5"> 
            BE<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence6a" value="6"> 
            B1<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence7a" value="7"> <br />
            C1<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence8a" value="8"> 
            C1E<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence9a" value="9"> 
            C<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence10a" value="10"> 
            CE<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence11a" value="11"> 
            D1<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence12a" value="12"> 
            D1E<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence13a" value="13"> 
            D<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence14a" value="14"> 
            DE<input class="wpja-width-reset wpja-driving-categories" type="checkbox" name="driving_licence15a" value="15"> 
            </div>
            </div>';
}
$string .= '<div style="clear:both;"></div>
      <div id="wpja-attachments">
      <p><b>ATTACHMENTS</b></p>
      <div id="wpja-attach-identification">
      <p><b>IDENTIFICATION</b></p>
      <label for="cv_resume"><b>CV/Resume*</b></label>
      <input class="wpja-input" type="file" name="cv_resume" required><br />
      <label for="photo_id"><b>Identity Card*</b></label>
      <input class="wpja-input" type="file" name="photo_id" required><br />
      <label for="passport"><b>Passport*</b></label>
      <input class="wpja-input" type="file" name="passport" required><br />
      </div>
      <div id="wpja-driving">
      <p><b>DRIVING</b></p>
      <label for="driving_licence">Driving licence</label>
      <input class="wpja-input" type="file" name="driving_licence"><br />
      <label for="international_driving_permit">International Driving Permit</label>
      <input class="wpja-input" type="file" name="international_driving_permit"><br />
      <label for="driving_licence_part2">Driving Licence 2nd Part</label>
      <input class="wpja-input" type="file" name="driving_licence_part2"><br />
      </div>
      <div id="wpja-education_certs">
      <p><b>EDUCATION CERTIFICATES</b></p>
      <label for="certificate1"><b>Certificate 1*</b></label>
      <input class="wpja-input" type="file" name="certificate1" required><br />
      <label for="certificate2"><b>Certificate 2*</b></label>
      <input class="wpja-input" type="file" name="certificate2" required><br />
      <label for="certificate3">Certificate 3</label>
      <input class="wpja-input" type="file" name="certificate3"><br />
      </div>
      <div id="wpja-work_certs">
      <p><b>WORK CERTIFICATES</b></p>
      <label for="certificate1"><b>Certificate 1*</b></label>
      <input class="wpja-input" type="file" name="certificate1w" required><br />
      <label for="certificate2"><b>Certificate 2*</b></label>
      <input class="wpja-input" type="file" name="certificate2w" required><br />
      <label for="certificate2">Certificate 3</label>
      <input class="wpja-input" type="file" name="certificate3w"><br />
      </div>
      <div id="wpja-police_cert">
      <p><b>CRIMINAL RECORD</b></p>
      <label for="police_conduct"><b>Police Conduct*</b></label>
      <input class="wpja-input" type="file" name="police_conduct" required><br />
      </div>
      </div>
      <p><i>Fields with <strong>*</strong> at the end are mandatory.</i></p>
      <button type="submit" name="submit_application">Submit</button>
      </form>
      </div>';