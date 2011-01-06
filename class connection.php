<?php
class databaseConnectionClass {
    public $con;
    function dbconnector($database,$status) {
        if($status) {
            //$database = "blog";
            $this ->con = mysql_connect("localhost","root","",$database);
            if (empty($this -> con))
                echo "Can't connected to mysql<br>";
            mysql_select_db($database);
        }
        else {
            mysql_close($this ->con);
            //echo "disconnected";
        }
    }

}
?>   