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
<html>
    <head>
        <link rel="stylesheet" title="Standard" href="./css/styles.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Standard" href="./css/main.css" type="text/css" media="screen" />
        <script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script language="JavaScript" type="text/javascript" src="./js/contentflow.js"></script>
        <script tyle="text/javascript">
            var cf = new ContentFlow('contentFlow', {reflectionColor: "#000000"});
        </script>
    </head>
    <!--<body style="background-color: black"> -->
    <body>
        
        <div id="logo">
        </div>
        <div id="main_container">

        <div class="maincontent">

            <!-- ===== FLOW ===== -->
            <div id="contentFlow" class="ContentFlow">
                <!-- should be place before flow so that contained images will be loaded first -->
                <div class="loadIndicator"><div class="indicator"></div></div>

                <div class="flow">
                    <?php
                    $listQuery = "SELECT * FROM winners ORDER BY id  DESC LIMIT 20";
                    $result = mysql_query($listQuery);
                    $noOfWinners = mysql_num_rows($result);

                    if($noOfWinners) {
                        while ($row = mysql_fetch_assoc($result)) {
                            ?>
                    <div class="item">
                        <h1><?php echo $row['id']; ?></h1>
                        <img class="content" src="./PR_PHOTO/<?php echo $row['pr_code'].".jpg"; ?>"/>
                        <div class="caption"><?php echo $row['pr_code']." : ". $row['name']; ?></div>
                    </div>
                            <?PHP  }
                    }
                    ?>
                    
                </div>
                <div class="globalCaption"></div>
                <div class="scrollbar">
                    <div class="slider"><div class="position"></div></div>
                </div>
            </div>
	</div>
            <embed src="Mega.wav" autostart="true" hidden="true" />
    </body>
</html>

