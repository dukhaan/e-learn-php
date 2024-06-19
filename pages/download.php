<?php
    if(ISSET($_REQUEST['file'])){
        $file = $_REQUEST['file'];

        header("Content-Disposition: attachment; filename=".basename($file));
        header("Content-Type: application/octet-stream;");
        readfile("assets/files/".$file);
    }
?> 