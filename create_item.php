  <?php


require_once('inc/config.php');
    if($_POST) {
        $itemname = $_POST['itemname'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $amount = $_POST['amount'];
     
        $sql = "INSERT INTO pawtrails (itemname, color, size, amount) VALUES ('$itemname', '$color', '$size', '$amount')";
        if($conn->query($sql) === TRUE) {
            echo "<p>New Record Successfully Created</p>";
            echo "<a href='dashboard.php'><button type='button'>Home</button></a>";
        } else {
            echo "Error " . $sql . ' ' . $conn->connect_error;
        }
     
        $conn->close();
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        add item
    </body>
    </html>