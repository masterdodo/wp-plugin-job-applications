<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$sql = "SELECT * FROM $table_applications ORDER BY surname, name";
$result = $wpdb->get_results($sql, ARRAY_A);
$count = $wpdb->num_rows;
if ($count < 0)
{
  exit;
}

$name = "";

echo "<table id=\"database\" style=\"table-layout: auto;\">";
echo "<thead>";
echo "<td>ID</td>";
echo "<td>NAME</td>";
echo "<td>SURNAME</td>";
echo "<td>GENDER</td>";
echo "<td>COUNTRY OF ORIGIN</td>";
echo "<td>PASSPORT</td>";
echo "<td>EDUCATION</td>";
echo "<td>POSITION</td>";
echo "<td>YRS EXP</td>";
echo "</thead>";
echo "<tbody>";
foreach($result as $row)
{
	if(isset($row['position_id']))
	{
		$sql1 = "SELECT name FROM $table_positions WHERE id= %d";
		$result1 = $wpdb->get_results($wpdb->prepare($sql1, $row['position_id']), ARRAY_A);
		foreach($result1 as $row1)
		{
			$name = $row1['name'];
		}
	}
	else if(isset($row['position_other']))
	{
		$name = $row['position_other'];
	}
	if (isset($row['education']))
	{
		$sql2 = "SELECT name FROM $table_education_levels WHERE id= %d";
		$result2 = $wpdb->get_results($wpdb->prepare($sql2, $row['education']), ARRAY_A);
		foreach($result2 as $row2)
		{
            $education = $row2['name'];
        }
	}
	if (isset ($row['country_origin']))
	{
		$sql3 = "SELECT country_name FROM $table_countries WHERE id= %d";
		$result3 = $wpdb->get_results($wpdb->prepare($sql3, $row['country_origin']), ARRAY_A);
		foreach($result3 as $row3)
		{
            $country_origin = $row3['country_name'];
        }
	}
	echo "<tr>";
	echo "<td>".esc_html($row['id'])."</td>";
	echo "<td>".esc_html($row['name'])."</td>";
	echo "<td>".esc_html($row['surname'])."</td>";
	echo "<td>".esc_html($row['gender'])."</td>";
	echo "<td>".esc_html($country_origin)."</td>";
	echo "<td>".esc_html($row['passport_number'])."</td>";
	echo "<td>".esc_html($education)."</td>";
	echo "<td>".esc_html(strtoupper($name))."</td>";
	echo "<td>".esc_html($row['xp'])."</td>";
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";