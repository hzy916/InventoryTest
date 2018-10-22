<?php 
 
 require_once('inc/config.php');

if($_GET['id']) {
    $id = $_GET['id'];
 
    $sql = "SELECT * FROM pawtrails WHERE id = {$id}";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
 
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Member</title>
</head>
<body>
 
<h3>Do you really want to remove ?</h3>
<form action="remove_item.php" method="post">
 
    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
    <button type="submit">Save Changes</button>
    <a href="dashboard.php"><button type="button">Back</button></a>
</form>
 
</body>
</html>
 
<?php
}
?>