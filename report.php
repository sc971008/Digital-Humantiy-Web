<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parse Report</title>
    <link rel="icon" type="image/x-icon" href="Cheng Shi-1.png" >
    <link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>

    <!-- navbar -->
    <div id="navbar_holder">
    </div>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script>
    $.get("navbar.html", function(data){
        $("#navbar_holder").replaceWith(data);
    });
    </script>
    <!-- navbar -->

    <!-- section -->
    <section id="sec_form">
        <h2>Parse Report</h2>

            <?php
$host = "mars.cs.qc.cuny.edu";
$db_name = "shch5304";
$db_port = 3306;
$db_username = "shch5304";
$db_password = "23375304";

// ------------------------------Creating connection to mars
$conn = mysqli_connect($host, $db_username, $db_password, $db_name, $db_port);

//if conn failed
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} else {
    echo "<span>&#9989</span>";
    echo "[Data Base Connection: Successfully]";
}

$retrive_src_sql = "SELECT * FROM source";
$result = mysqli_query($conn, $retrive_src_sql);
//------------------------------generate Table header
echo "<br>";
echo "<table border='1'>";
//table header
echo "<thead>";
echo "<tr>";
echo "<th >SourceID</th>";
echo "<th >Name</th>";
echo "<th >URL</th>";
echo "<th >Begin</th>";
echo "<th >End</th>";
echo "<th >Time</th>";
echo "<th >Detail</th>";
echo "</tr>";
echo "</thead>";
//------------------------------table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($row as $value) {
        if ($value === $row['source_url'] & $value != null) {
            echo "<td>" . "<a href='$value'>Link</a>" . "</td>";
        } else {
            echo "<td>" . $value . "</td>";
        }

    }
    //<Form Button> to get to go to  details.php page
    echo "<td>";
    echo "<form method='GET' action='detail.php'>";
    echo "<input type='hidden' name='src_id' value=" . $row['source_id'] . ">";
    echo "<input type='submit' value='Details Report'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>

        </tbody>
        </table>
    </section>
    <!-- section -->

    <div id="copyright">
		<a href="http://www.cs.qc.cuny.edu">Computer Science Department</a>&nbsp; | &nbsp;
		<a href="http://www.qc.cuny.edu/Academics/Degrees/DMNS/">School of Mathematics and Natural Sciences</a> &nbsp; | &nbsp;
		<a href="http://www.qc.cuny.edu">Queens College</a> &nbsp;| &nbsp;
		<a href="http://www.cuny.edu">City University of New York</a>
		<br>
		<br>
		Copyright 2022 © Cheng Shi | Department of Computer Science, CUNY Queens College.
		<a href="contact.html">Contact Information</a>
	</div>

</body>
</html>
