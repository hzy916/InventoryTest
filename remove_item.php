<?php 
 
require_once('inc/config.php');

if($_POST) {
    $id = $_POST['id'];
 
    $sql = "DELETE FROM pawtrails WHERE id = {$id}";
    if($conn->query($sql) === TRUE) {
        echo "<p>Successfully removed!!</p>";
        echo "<a href='dashboard.php'><button type='button'>Back</button></a>";
    } else {
        echo "Error updating record : " . $conn->error;
    }
    $conn->close();
}
 
?>
