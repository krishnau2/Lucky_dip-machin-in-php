
<?php include 'class connection.php'; ?>

<?php
// Database connection parameters
$connect = 1;
$disconnect = 0;
$database = "sph_lucky"; // Database used.
//Database connection object creation
$lucky_lote = new databaseConnectionClass();
//Accessing the database connection function
$lucky_lote->dbconnector($database, $connect);
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
$lote_start = $row['start'];
$lote_end = $row['end'];
$next_lote = $row['next_lot'];
// Taking the data from the associated file
$path = "C:\lucky\LOT";

//This is to prevent accidental refreshing of page
// If page is refreshed the problem will happend is the same text file is
// selected again and the same data is repeated in the registratiion so 24 + 24
// PR CODE of repeated data will be inserted to registration table
// How it is prevented ?
//Next_lote_no field is created in the lote_no table.
//It is updated after one file is copyied to registration table.
// The lote_no, start and end fields will be updated after completion of one round.
// Checks the next loteno with current lote_no if the difference is one the corresponding
// file is copyied to the registration table.
// Otherwise do nothing.
if ($next_lote == ($lote_no + 1)) {

    $file = fopen($path.$lote_no . ".TXT", "r") or exit("Unable to open file!");

    while (!feof($file)) {
        $ch = fgets($file);
        list($code) = explode("|", trim($ch));
        if ($code != "") {
            // storing the file data to mysql registration table
            $insertionQuery = "INSERT INTO registration VALUES (NULL,'$code','$lote_no','N')";
            $result = mysql_query($insertionQuery);
            echo mysql_error();
        }
    }
    fclose($file);
    $next_lote = $next_lote + 1;
    $updateQuery = "UPDATE lote_no SET next_lot='$next_lote'";
    $updateResult = mysql_query($updateQuery);
    echo mysql_error();
}
?>

<html>
    <head>
        <link rel="stylesheet" title="Standard" href="./css/main.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Standard" href="./css/firstPage.css" type="text/css" media="screen" />
        <script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="./js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
        <script type="text/javascript" type="text/javascript" >
            function introduction(){
                $("#sound").html("<embed src=\"Intro.wav\" autostart=\"true\" hidden=\"true\"/>");
                setTimeout('Redirect()',60000);
            }
            function Redirect(){
                window.location = "./shufflePage.php"
            }
        </script>
    </head>
    <body onLoad="introduction()">
        <div id="logo">
        </div>
        <div id="main_container">

            <div id="list_container">
                <?php
// Showing the participants of the current lot.
                $query = "SELECT * FROM registration WHERE lote_no ='$lote_no' ";
                $result = mysql_query($query);
                $noOfParticipants = mysql_num_rows($result);

                if ($noOfParticipants) {
                    while ($row = mysql_fetch_assoc($result)) {
                ?>
                        <div id="item">
                            <img src="./PR_PHOTO/<?php echo $row['pr_code'] . ".jpg"; ?>" width="165" height="155">
                            <div id="code"><?php echo $row['pr_code'] ?></div>
                        </div>

                <?PHP
                    }
                }
                ?>
            </div>
            <div id="lot_no">Lot No. <?php echo $lote_no; ?></div>
        </div>
        <div id="sound"></div>
        <a href="./shufflePage.php">SKIP</a>
    </body>
</html>