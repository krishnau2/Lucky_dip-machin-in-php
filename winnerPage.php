<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="./css/main.css" />
        <script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="./js/jquery-ui-1.7.2.custom.min.js"></script>
        <script src="./js/jquery.flip.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {
                $("#orginal").hide();
                $("#details").hide();
                var container			= $('#container');
                var containerHeight	= parseInt(container.height())/50;
                var containerWidth	= parseInt(container.width())/50;
                var blockCount			= (containerHeight * containerWidth);
                var temp = 1;
                for(x = 1; x <= blockCount; x++) {

                    randomNum			= Math.floor(Math.random()*4) + parseFloat(1);
                    container.append('<div class="block' + randomNum + '"></div>');
                }

                $('#container div').addClass('black');

                var stack = {
                    'delay': 150,
                    'actions': [],
                    'run': function() {
                        if (stack.actions.length) {
                            stack.actions.shift()();
                            setTimeout(stack.run, stack.delay);
                        }
                    }
                };


                $('#container div').each(function(){
                    var that = this;
                    stack.actions.push(function(){
                        $(that).flip({
                            color: '#ffffff',
                            speed: 70,
                            direction:'lr',
                            onEnd: function() {
                                $(that).removeClass('black');
                                if(temp==blockCount){
                                    $("#orginal").fadeIn(5000);
                                    $("#details").fadeIn(5000);
                                }
                                temp=temp+1;
                            }
                        });
                    });
                });
                stack.run();

            });

        </script>
        <script type="text/javascript">
            function delayedRedirect(){
                window.location = "./winnersList.php"
            }
            function startAnounce(file,winner){
                $("#sound").html("<embed src="+file+" autostart=\"true\" hidden=\"true\"/>");
                setTimeout('anounceWinner(winner)',7000);
            }
            function anounceWinner(file){
                $("#sound").html("<embed src="+file+" autostart=\"true\" hidden=\"true\"/>");
            }
			
        </script>
    </head>
    <body onLoad="setTimeout('delayedRedirect()', 50000)">
        <?php
// taking the lote no from table for identifying the current lote no.
// and file to which data is to be taken
        $lote_no_query = "SELECT * FROM lote_no";
        $result = mysql_query($lote_no_query);
        $row = mysql_fetch_assoc($result);
//        echo $row['lot_no']."<br>";
//        echo $row['start']."<br>";
//        echo $row['end']."<br>";
        $lote_no = $row['lot_no'];
        $lote_start = $row['start'];
        $lote_end = $row['end'];
        $participant_limit = $row['participant_limit'];
// selecting a random no between start and end of the lote section.
        $random = rand($row['start'], $row['end']);
//echo 'Random no'. $random."<br>";
// selectin a PR using the random no generated .
        $selectiion_query = "SELECT * FROM registration WHERE id ='$random' AND participated='N'";
        $selection_result = mysql_query($selectiion_query);
        $winner = mysql_num_rows($selection_result);
        if ($winner) {
            $selected_row = mysql_fetch_assoc($selection_result);

//        echo $selected_row['id']."<br>";
//        echo $selected_row['pr_code']."<br>";
            $lucky_pr = $selected_row['pr_code'];

            // collecting PR NAME OF THE SELECTED PR FROM ONAM1155 TABLE.
            $name_selectiion_query = "SELECT * FROM ONAM1155 WHERE CODE='$lucky_pr'";
            $name_selection_result = mysql_query($name_selectiion_query);
            $name_selected_row = mysql_fetch_assoc($name_selection_result);
            echo mysql_error();

//        echo $name_selected_row['CODE']."<br>";
//        echo $name_selected_row['NAME']."<br>";
            $lucky_pr_name = $name_selected_row['NAME'];

            // Showing the picture of the current lucky winner.
//        echo '<img src=./PR_PHOTO/'.$lucky_pr.".jpg>";
        ?>
            <div id="logo">
            </div>
            <!-- PHP CODE WILL GOES HERE -->
            <div id="main_container">
                <div id="container" style="background:#fff url('./PR_PHOTO/<?php echo $lucky_pr . ".jpg"; ?>') center center no-repeat;" >
                    <div id="orginal" style="background:#fff url('./PR_PHOTO/<?php echo $lucky_pr . ".jpg"; ?>') center center no-repeat;">
                        <!--<img src="./PR_PHOTO/S738.jpg" alt="test_photo"  id=""/>-->
                    </div>
                </div>
                <div id="details">
                <?php echo $lucky_pr; ?> <br> <?php echo $lucky_pr_name; ?>
            </div>
        </div>
        <?php
                //storing the current winner to the WINNER table .
                $time = date("H:i:s", time());
//        echo $time;
                $insertionQuery = "INSERT INTO winners VALUES (NULL,'$lucky_pr','$lucky_pr_name','$lote_no','')";
                $result = mysql_query($insertionQuery);

                // updating the participation field of the registratiion table.
                $updateQuery = "UPDATE registration SET participated='Y'";
                $updateResult = mysql_query($updateQuery);
                echo mysql_error();

                // Updating the lote_no table (lot_no, start, end).
                // new lote no = current lote no + 1
                // new start = current end + 1.
                // new end = new start + participant_limit.
                $new_lote_no = $lote_no + 1;
                $new_start = $lote_end + 1;
                $new_end = $new_start + $participant_limit;
                $updateQuery = "UPDATE lote_no SET lot_no ='$new_lote_no',start='$new_start',end='$new_end'";
                $updateResult = mysql_query($updateQuery);
                echo mysql_error();
        ?>
            <embed src="./sound/Lucky_Winner.wav" autostart="true" hidden="true"/>
            <div id="sound"></div>
    <?php
                $lot_path = "./count/";
                $sound_lot = $lote_no.".wav"; // SHOULD BE CHANGED TO $lote_no. ON DEPLOYMENT.
                $sound_path = "./sound/";
                //$winner = "winner.wma";// comment this line on DEPLOYMENT.
                $winner = $lucky_pr . ".wav"; // Uncomment this line on implementation.
                // this is for anouncing the sph 50 yr lucky winner is.
                echo "<script type=\"text/javascript\">var file=\"$lot_path$sound_lot\"; var winner=\"$sound_path$winner\"; setTimeout('startAnounce(file,winner)', 20000);</script>";
            } else {
                echo "Start from first page.... <a href='index.php'>Back</a>";
            }
    ?>

</body>
</html>
