<?php 
    include __DIR__."/resource/database/db_config.php";
    function checkTimeout(){
        try {
            $conn = DB::getConnect();
            $sql = "SELECT sales.*,img_confirm.img,img_confirm.id as img_id\n".
                    "			,TIMESTAMPDIFF(MINUTE,reg_date,CURRENT_TIMESTAMP) as 'use_time' \n".
                    "FROM sales INNER JOIN img_confirm\n".
                    "ON sales.id = img_confirm.sale_id\n".
                    "WHERE img_confirm.img IS NULL";
            $result = $conn->query($sql);
            while(($row=$result->fetch_array())!=null){
                if(intval($row["use_time"])>30){
                    $sql ="DELETE FROM img_confirm WHERE id = ".$row["img_id"];
                    $conn->query($sql);
                    $sql = "DELETE FROM sales WHERE id = ".$row["id"];
                    $conn->query($sql);
                }
            }
            $conn->close();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
    checkTimeout();
?>