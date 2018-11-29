<?php

if (isset($_GET['file'])) {
    $path = $_GET['file'];
    $filename = basename($_GET['file']);

    // print($path);
    // echo "<br>";
    // print($filename);
    // exit;


} else {
    $filename = false;
}

// define error message
$err = '<p style="color:#990000">Sorry, the file you are requesting is unavailable.</p>';
//allow file to download
    if (!isset($filename)) {
        // if variable $filename is NULL or false display the message
        echo $err;
    } else {
        
        //check which file  extension it is
        $file_extension = strtolower(substr(strrchr($filename,"."),1));
        switch( $file_extension ) {
            case "pdf": $ctype="image/pdf"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpeg"; break;
            default:
        }

        // check that file exists and is readable
        if (file_exists($path) && is_readable($path)) {
           
            // get the file size and send the http headers
            $size = filesize($path);
            header('Content-Type: ' .$ctype);
            header('Content-Length: '.$size);
            header('Content-Disposition: attachment; filename='.$filename);
            header('Content-Transfer-Encoding: binary');

            ob_clean();
            // open the file in binary read-only mode

            // display the error message if file can't be opened
            $file = @ fopen($path, 'rb');
            if ($file) {
                // stream the file and exit the script when complete
                fpassthru($file);
                exit;
            } else {
                echo "first line <br>".$err;
            }
        } else {
          
            echo "file doesn't exsit ".$filename."<br>";
            echo "file path <br>".$path;
        }
    }
    ?>