<?php 
 
	
 require_once('inc/config.php');

if($_POST) {
    // $itemname = $_POST['itemname'];
    // $color = $_POST['color'];
    // $size = $_POST['size'];
    $amount = $_POST['amount'];
 
    $id = $_POST['id'];
 
    $sql = "UPDATE pawtrails SET amount = '$amount', date = CURRENT_TIMESTAMP WHERE id = {$id}";
    if($conn->query($sql) === TRUE) {
        echo "<p>Succcessfully Updated</p>";
        
        echo "<a href='dashboard.php'><button type='button'>Home</button></a>";
    } else {
        echo "Erorr while updating record : ". $conn->error;
    }
 
    $conn->close();
 
}
 
?>