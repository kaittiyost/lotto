<?php 
    include(__DIR__."/../database/db_config.php");
    class GetData{
        public static function lottery(){
            $conn = DB::getConnect();
            $sql = "SELECT * FROM lottery WHERE status = 1";
            $result = $conn->query($sql);
            return ($conn->affected_rows<=0)?NULL:$result;
        }
    }
?>