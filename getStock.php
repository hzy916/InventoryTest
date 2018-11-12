<?php
if(isset($_POST['sel_color']) && isset($_POST['sel_size'])){
    $sql = "SELECT amount FROM pawtrails WHERE color = '".$_POST['sel_color']."' AND WHERE size = '".$_POST['sel_size']."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
         
            echo $row['amount'];
          
        }
    }
    $sql = NULL;
}


?>