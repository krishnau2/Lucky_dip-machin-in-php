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
        <link rel="stylesheet" type="text/css" media="screen, projection" href="./css/report.css" />
    </head>
    <title>Onam 2010 Lucky Draw WINNERS </title>
    <body>
        <center><h2>SPH</h2><h4>Onam 2010 Lucky Draw WINNERS </h4><h4>Lucky Draw order</h4> </center>
        <table class="tablesorter" border="1">
            <thead>
                <tr>
                    <th width="20">SL</th>
                    <th width="30">CODE</th>
                    <th width="250">NAME</th>
                    <th width="20">LOT No.</th>
                    <th></th>
                </tr>
            </thead>
            <?php
            $listQuery = "SELECT * FROM winners";
            $result = mysql_query($listQuery);
            $noOfWinners = mysql_num_rows($result);
            $sl = 1;
            $pg = $sl + 32;
            if ($noOfWinners) {
                while ($row = mysql_fetch_assoc($result)) {
                    if ($pg == $sl) {
            ?>

            <?php
                        $pg = $sl + 32;
                    }
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $sl ?></td>
                            <td><?php echo $row['pr_code']; ?></td>
                            <td><?php echo $row['name'] ?> </td>
                            <td><?php echo $row['lote_no'] ?></td>
                        </tr>
                <?PHP
                    $sl = $sl + 1;
                }
            }
                ?>
            </tbody>            

        </table>
        
        <br><br><br><br><br><br><br><br><br><br><br><br>
        
        <center><h2>SPH</h2><h4>Onam 2010 Lucky Draw WINNERS </h4><h4>CODE order</h4> </center>
        <table class="tablesorter" border="1">
            <thead>
                <tr>
                    <th width="20">SL</th>
                    <th width="30">CODE</th>
                    <th width="250">NAME</th>
                    <th width="20">LOT No.</th>
                    <th></th>
                </tr>
            </thead>
            <?php
            $listQuery = "SELECT * FROM winners ORDER BY pr_code";
            $result = mysql_query($listQuery);
            $noOfWinners = mysql_num_rows($result);
            $sl = 1;
            $pg = $sl + 32;
            if ($noOfWinners) {
                while ($row = mysql_fetch_assoc($result)) {
                    if ($pg == $sl) {
            ?>

            <?php
                        $pg = $sl + 32;
                    }
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $sl ?></td>
                            <td><?php echo $row['pr_code']; ?></td>
                            <td><?php echo $row['name'] ?> </td>
                            <td><?php echo $row['lote_no'] ?></td>
                        </tr>
                <?PHP
                    $sl = $sl + 1;
                }
            }
                ?>
            </tbody>
        </table>
    </body>
</html>