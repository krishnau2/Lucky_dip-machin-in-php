<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php include 'class connection.php'; ?>

<?php
// Database connection parameters
$connect=1;
$disconnect=0;
$database="sph_lucky"; // Database used.

//Database connection object creation
$lucky_lote=new databaseConnectionClass();
//Accessing the database connection function
$lucky_lote ->dbconnector($database, $connect);
?>

<?php
// taking the lote no from table for identifying the current lote no.
// and file to which data is to be taken
$lote_no_query = "SELECT * FROM lote_no";
$result = mysql_query($lote_no_query);
$row = mysql_fetch_assoc($result);
//echo $row['lot_no']."<br>";
//echo $row['start']."<br>";
//echo $row['end']."<br>";
$lote_no = $row['lot_no'];
?>

<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title></title>
        <script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="./js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>        
        <link rel="stylesheet" type="text/css" media="screen, projection" href="./css/main.css" />
        <script type="text/javascript">
            function delayedRedirect(){
                window.location = "./winnerPage.php"
                // $("#sound").html("<embed src=\"Lucky_Winner.wav\" autostart=\"true\" hidden=\"true\"/>");
            }
        </script>
    </head>
    <body onLoad="setTimeout('delayedRedirect()', 30000)">
        <div id="logo">
        </div>
        <div id="main_container">
        
        <embed src="shuffle.wav" autostart="true" hidden="true"/>
        <ul>
            <li>?</li>
            <?php
            // Showing the participants of the current lot. for shuffling
            $query = "SELECT * FROM registration WHERE lote_no ='$lote_no' ";
            $result = mysql_query($query);
            $noOfParticipants = mysql_num_rows($result);

            if($noOfParticipants) {
                while ($row = mysql_fetch_assoc($result)) {

                    ?>
            <li id="a"><img src="./PR_PHOTO/<?php echo $row['pr_code'].".jpg"; ?>" alt="" width="150" height="150"/></li>
 
                    <?PHP  }
            }
            ?>
    </ul>
	</div>
    </body>
    <script src="./js/drawScript.js" type="text/javascript"></script>
</html>
