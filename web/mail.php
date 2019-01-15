    <?php
    require_once('inc/config.php');
    /* Include the Composer generated autoload.php file. */
    require 'vendor/autoload.php';
 

    function sendMail($receivers=array(),$subject,$body){
         /* Create a new PHPMailer object. */
        $mail = new PHPMailer\PHPMailer\PHPMailer();
 
         try{
        /* Set the mail sender. */
        $mail->setFrom('notification-no-reply@pawtrails.com', 'PawTrails Portal');
        /* Add a recipient. */
        if(empty($receivers)) {
            return false;
        }
        foreach($receivers as $k => $v) {
            $mail->addAddress($k, $v);
        }
        
    
        /* Add a cc recipient. */
        // $mail->addCC('andrea@attitudetech.ie', 'andrea');
        
        
        /* Set the subject. */
        $mail->Subject = $subject;
        /* Set the mail message body. */
        $mail->Body = $body;

        //setting cc email receiver 
        $ccEmailaddress = 'songtao@attitudetech.ie';
         /* SMTP parameters. */
   
        /* Tells PHPMailer to use SMTP. */
        $mail->isSMTP(); 
        /* SMTP server address. */
        $mail->Host = 'smtp.gmail.com';
        /* Use SMTP authentication. */
        $mail->SMTPAuth = TRUE;
        /* Set the encryption system. */
        $mail->SMTPSecure = 'tls';
        /* SMTP authentication username. */
        $mail->Username = 'notification-no-reply@pawtrails.com';
        /* SMTP authentication password. */
        $mail->Password = 'Attitudetech2017';
        
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
    }

   
    // }




?>