    <?php
    require_once('inc/config.php');
    /* Include the Composer generated autoload.php file. */
    require 'vendor/autoload.php';
 
//   $id = $_POST["requestID"];

//     $output = null;

//     if(!empty($id)){
//         $sql = "SELECT Request.RequestEmployeeID, Request.RequestStatusID, Request_status.status_name, tbl_users.user_name, tbl_users.email FROM Request JOIN Request_status ON Request.RequestStatusID = Request_status.status_id JOIN tbl_users ON  Request.RequestEmployeeID = tbl_users.id WHERE Request.RequestID = '{$id}'";

//         $result = $conn->query($sql);
        
//         $data = $result->fetch_assoc();

//         $output = $data['user_name'] . '  request status changed to ' .$data['status_name'] . 'The request ID is '.$data['RequestID'] ;
        
//         $to = $data['email'];
//         $subject = "Request Status changed";
      
//         $headers = "From: test@test.com" . "\r\n" .
//         "CC: somebodyelse@example.com";
        
//         mail($to,$subject,$output,$headers);
    // }


    if($output === null){
        header('HTTP/1.0 400 Bad Request');
    }else{
        echo $output;
    }

    /* Create a new PHPMailer object. */
    $mail = new PHPMailer();

    $mailBody = '';

    $sql = '';

    while($row = mysqli_fetch_array($result)){
        $mailBody .= $row['Expiration_Message'] . "<br>\n";
    }

    try{
        /* Set the mail sender. */
        $mail->setFrom('test@pawtrails.com', 'Ziyun He');
        /* Add a recipient. */
        $mail->addAddress($requestEmployee, 'Test');
        $mail->addAddress($admin, 'Songtao');
        /* Add a cc recipient. */
        // $mail->addCC('admiral@empire.com', 'Fleet Admiral');
        /* Set the subject. */
        $mail->Subject = $subject;
        /* Set the mail message body. */
        $mail->Body = 'There is one new delivery request submitted.';
         /* SMTP parameters. */
   
        /* Tells PHPMailer to use SMTP. */
        $mail->isSMTP(); 
        /* SMTP server address. */
        $mail->Host = 'smtp.empire.com';
        /* Use SMTP authentication. */
        $mail->SMTPAuth = TRUE;
        /* Set the encryption system. */
        $mail->SMTPSecure = 'tls';
        /* SMTP authentication username. */
        $mail->Username = 'smtp@empire.com';
        /* SMTP authentication password. */
        $mail->Password = 'hhhh';
        
        /* Set the SMTP port. */
        $mail->Port = 587;
        /* Disable some SSL checks. */
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );
        /* Finally send the mail. */
        $mail->send();
        }

        catch (Exception $e)
        {
        echo $e->errorMessage();
        }
        catch (\Exception $e)
        {
        echo $e->getMessage();
        }

?>