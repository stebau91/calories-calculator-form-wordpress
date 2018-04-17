

<?php

function dish_show_callback() {     
    global $wpdb;
    $dish=$_GET['dish'];
    $result =   $mytables=$wpdb->get_results("select name from ".$wpdb->prefix . "global where name like '%".$dish."'" );   
    $data = "";
    foreach($result as $dis)
        {
            $data.=$dis->dish."<br>";
        }    
    echo $data;
    die();
    }
add_action( 'wp_ajax_city_action', 'city_action_callback' );
add_action( 'wp_ajax_nopriv_city_action', 'city_action_callback' );
?>