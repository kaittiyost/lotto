<?php 
    function login_success(){
        $login_data = ["status"=>1];
        echo json_encode($login_data);
    }

    if(isset($_POST["func"])){
        if($_POST["func"]=="login"){
            login_success();
        }
    }
?>