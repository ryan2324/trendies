<?php
    session_start();
    if(isset($_GET['logout'])){
        echo 'something';
        session_destroy();
    }