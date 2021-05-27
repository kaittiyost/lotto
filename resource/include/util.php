<?php 
    class Util{

        public static function intToThai($number){
            $arr = str_split((String)$number);
            $newString = "";
            foreach($arr as $num){
                $newString .= self::intToChar($num)."  ";
            }
            return $newString;
        }

        public function intToChar($num){
            $newString = "";
            switch(intval($num)){
                case 0 :
                     $newString = "ศูนย์";
                     break;
                 case 1 :
                     $newString = "หนึ่ง";
                     break;
                 case 2 :
                     $newString = "สอง";
                     break;
                 case 3 :
                     $newString = "สาม";
                     break;
                 case 4 :
                     $newString = "สี่";
                     break;
                case 5 :
                    $newString = "ห้า";
                    break; 
                case 6 :
                    $newString = "หก";
                    break; 
                case 7 :
                    $newString = "เจ็ด";
                    break;    
                case 8 :
                    $newString = "แปด";
                    break;                      
                case 9 :
                    $newString = "เก้า";
                    break;             
            }
            return $newString;
        }
    }
?>