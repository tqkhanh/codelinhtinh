<?php
// define mysql connect
$dbname = '';
$dbuser = '';
$dbpass = '';
$dbhost = 'localhost'; // this can usually stay 'localhost'
 
$wp_table = 'kuti_posts'; // define wordpress table name  
 
$gmt_offset = '+7'; // -8 for California, -5 New York, +8 Hong Kong, etc.
 
$min_days_old = 1; // the minimum number of days old
$max_days_old = 800; // the maximum number of days old
 
// connect to db
$link=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
mysqli_select_db($link);
 
 
$result = mysqli_query($link,"SELECT ID FROM $wp_table WHERE post_type = 'post'") or die(mysqli_error()); 
while ($l = mysqli_fetch_array($result)) {
    $post_id = $l['ID'];
    echo "Updating: $post_id <br>";
 
    $day = rand($min_days_old, $max_days_old);
    $hour = rand(0, 23);
 
    $new_date = date( 'Y-m-d H:i:s', strtotime("-$day day -$hour hour") );  
    $gmt_new_date = date( 'Y-m-d H:i:s', strtotime("-$day day -$hour hour -$gmt_offset hour") );
 
    mysqli_query($link,"UPDATE $wp_table SET post_date='$new_date', post_date_gmt='$gmt_new_date',
    post_modified='$new_date', post_modified_gmt='$gmt_new_date' WHERE ID='$post_id'")
    or die(mysql_error()); 
 
}
 
echo "<hr>DONE!";
 
?>
