<?php 
    include(__DIR__."/../database/db_config.php");
    class GetData{
        public static function lottery($key){
            try{
                $conn = DB::getConnect();
                if(is_null($key)){
                    $sql = "SELECT * FROM lottery WHERE status = 1";
                    $result = $conn->query($sql);
                    return ($conn->affected_rows<=0)?NULL:$result;
                }else{
                    $key = htmlentities($conn->escape_string($key));
                    $key = str_replace("a","_",$key);
                    $sql = "SELECT * FROM lottery WHERE status = 1 AND number LIKE '".$key."'";
                    $result = $conn->query($sql);
                    return ($conn->affected_rows<=0)?NULL:$result;
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
?>