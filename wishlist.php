<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        Wish List of <?php echo htmlentities($_GET["user"])."<br/>";?>
        <?php
            $con = mysqli_connect("localhost", "root", "");
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                       . mysqli_connect_error());
            }
            //set the default client character set 
            mysqli_set_charset($con, 'utf-8');

            mysqli_select_db($con, "wishlist");

            $user = mysqli_real_escape_string($con, htmlentities($_GET["user"]));

            $wisherids = mysqli_query($con, "SELECT id FROM wishers WHERE name='" . $user . "'");

            if (mysqli_num_rows($wisherids) < 1) {
                exit("The person " . htmlentities($_GET["user"]) . " is not found. Please check the spelling and try again");
            }
            $row = mysqli_fetch_row($wisherids);
            $wisherID = $row[0];
            mysqli_free_result($wisherids);           
        ?>
        
        <table border="black">
            <tr>
                <th>Item</th>
                <th>Due Date</th>
            </tr>
            <?php
            $result = mysqli_query($con, "SELECT description, due_date FROM wishes WHERE wisher_id=" . $wisherID);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . htmlentities($row["description"]) . "</td>";
                echo "<td>" . htmlentities($row["due_date"]) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            mysqli_close($con);
            ?> 
        </table>
        
       
    </body>
</html>
