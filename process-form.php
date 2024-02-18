<?php
/**
 * Form Processing:
 * Create a new table for the data base and fill in the data received from my-plugin.php
 */

// get root path
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
    // get database
    require_once($root.'/wp-load.php');
}

global $wpdb;
// set the name of our new table
$rd_table_name = $wpdb->prefix . 'rd_mailer_forms';

// only create a new table, if it doesn't already exist
$val = false;

// check if the table exists with the given name (specified above as $rd_table_name)
$stock_table = $wpdb->prefix . $rd_table_name;
$query = $wpdb->prepare("SELECT * FROM $stock_table");
$results = $wpdb->get_results($query);

if (empty($results)) {
    // table does not exist
    $val = false;
} else {
    // table exists
    $val = true;
}
    
if($val !== false)
{
    // table exists, so stop function execution
    return false;
} else {
    create_the_custom_table();
}

 function create_the_custom_table() {
    echo "Hello from create_the_custom_table()<br />";

    global $root;
    global $wpdb;
    global $rd_table_name;
    
    // sanitize form input and assign each one to a variable
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $fName = filter_var($_POST['fName'], FILTER_SANITIZE_STRING);
    $lName = filter_var($_POST['lName'], FILTER_SANITIZE_STRING);
    $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

    // table does not exist, so make it
    $charset_collate = $wpdb->get_charset_collate();
        
    $sql = "CREATE TABLE " . $rd_table_name . " (
    id int(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    fName tinytext NOT NULL,
    lName tinytext NOT NULL,
    dob tinytext NOT NULL,
    phone tinytext NOT NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // insert values into the database table
    $wpdb->insert( 
        $rd_table_name,
        array(
            'email' => (string) $email,
            'fName' => (string) $fName,
            'lName' => (string) $lName,
            'dob' => (string) $dob,
            'phone' => (string) $phone
        )
    );
    $record_id = $wpdb->insert_id;

    echo "Your response has been entered into our database.<br />";
    echo '<a href="pdf-download.php?email='.$email.'">Click here to download your PDF document.</a><br />';

    sendEmail($email);
}

function sendEmail($email) {
    global $root;

    $to = $email;
    $subject = 'Congratulations on your certificate!';
    $message = '
        Congratulations for filling up our form! Please find below a link where you can download your certificate: 
        <a href="' . $root . '/wp-content/plugins/rubber-duck-mailer/pdf-download.php?email='.$email.'">Download PDF</a>            
    ';

    $headers = array('Content-Type: text/plain');

    $result = wp_mail($to, $subject, $message, $headers);

    if ($result) {
        echo 'We also sent an email to: '.$email.'<br />';
    } else {
        echo 'Email failed to send.<br />';
    }
}
