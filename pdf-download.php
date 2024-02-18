<?php
// required files
require_once 'dompdf/autoload.inc.php'; // this is a third party PDF generator

// get root path
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
    // get database
    require_once($root.'/wp-load.php');
} else {
    die("can't get wp-load.php");
}

global $wpdb;
// set the name of our new table
$rd_table_name = $wpdb->prefix . 'rd_mailer_forms';
echo "table name: " . $rd_table_name . "<br />";

// this will get the data from your table
$email = sanitize_text_field($_GET['email']);
echo "got email: " . $email . "<br />";

$sql = "SELECT * FROM " . $rd_table_name;

$output = "<h1>Your Certificate</h1>";
$posts = $wpdb->get_results($sql);
foreach ($posts as $post) {
    if($post->email == $email) {
        $output .= "<ul>";
        $output .= "<li>Email: " . strip_tags($post->email) . "</li>";
        $output .= "<li>First Name: " . strip_tags($post->fName) . "</li>";
        $output .= "<li>Last Name: " . strip_tags($post->lName) . "</li>";
        $output .= "<li>Date of Birth: " . strip_tags($post->dob) . "</li>";
        $output .= "<li>Phone Number: " . strip_tags($post->phone) . "</li>";
        $output .= "</ul>";
    }
}
$output .= '';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
// $dompdf->loadHtml("This is your certificate! It's a placeholder.");
$dompdf->loadHtml($output);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();