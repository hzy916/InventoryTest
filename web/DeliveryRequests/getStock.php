<?php
require_once('../inc/config.php');

$json = file_get_contents('php://input');


$obj = json_decode($json, TRUE);


$output = null;

if(!empty( $obj['color']) && !empty($obj['size'])){
    $sql = "SELECT amount FROM pawtrails WHERE color = '".$obj['color']."' AND size = '".$obj['size']."' LIMIT 0, 1";
    $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $output = $row['amount'];
    }
}



if($output === null){
    header('HTTP/1.0 400 Bad Request');
}else{
    echo $output;
}

?>