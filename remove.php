<?php 
 
 require_once('inc/config.php');

if($_GET['id']) {
    $id = $_GET['id'];
 
    $sql = "SELECT * FROM pawtrails WHERE id = {$id}";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();


    if($_POST) {
        $id = $_POST['id'];
    
        $sql = "DELETE FROM pawtrails WHERE id = {$id}";
        if($conn->query($sql) === TRUE) {
        
            echo "<script>
            alert('Item is removed successfully !!');
            window.location.href='./inventory.php';
            </script>";

        } else {
            echo "Error updating record : " . $conn->error;
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Item</title>
</head>
<body>
 
<h3>Do you really want to remove ?</h3>
<form method="post">
 
    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
    <button type="submit">Yes</button>
    <a href="inventory.php"><button type="button">Cancel</button></a>
</form>
 
</body>
</html>
 
