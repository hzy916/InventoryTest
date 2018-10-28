<?php 
 
 require_once('inc/config.php');

if($_GET['id']) {
    $id = $_GET['id'];
 
    $sql = "SELECT * FROM Pawtrails_Request_junction WHERE id = {$id}";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    if($_POST) {
        $id = $_POST['id'];
    
        $sql = "DELETE FROM Pawtrails_Request_junction WHERE id = {$id}";
        if($conn->query($sql) === TRUE) {
            echo "<p>Successfully removed!!</p>";
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
    <title>Remove Member</title>
</head>
<body>
 
<h3>Do you really want to remove ?</h3>
<form method="post">
 
    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
    <button type="submit">Save Changes</button>
    <a href="delivery_request.php"><button type="button">Back</button></a>
</form>
 
</body>
</html>
 
