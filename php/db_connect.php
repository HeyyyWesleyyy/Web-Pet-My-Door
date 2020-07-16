<?php
    $servername = "143.106.241.3";
    $username = "cl19479";
    $password = "cl*20082000";
    $db_name = "cl19479";

    $connect = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_set_charset($connect, "utf8");
    if(mysqli_connect_error()){
        echo "Falha na conexão: ".mysqli_connect_error();
    }
?>