<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Source Details Page</title>
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
        <h2><?php echo "Details Report" ?></h2>

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
    echo "<br><span>&#9989</span>";
    echo "[Data Base Connection: Successfully]";
}
//query
$retrive_ocu_sql = "SELECT * FROM occurrence WHERE source_id=" . $_GET['src_id'] . " ORDER BY freq DESC";
$result = mysqli_query($conn, $retrive_ocu_sql);

$total_word_sql = "SELECT SUM(freq) as total_word FROM occurrence WHERE source_id=" . $_GET['src_id'];
$total_word_res = mysqli_query($conn, $total_word_sql);
$total_word_ct = mysqli_fetch_assoc($total_word_res);

$get_srcname_sql = "SELECT source_name FROM source WHERE source_id=" . $_GET['src_id'];
$srcname_res = mysqli_query($conn, $get_srcname_sql);
$name_row = mysqli_fetch_assoc($srcname_res);
$src_name = $name_row['source_name'];

//------------------------------generate Table
echo "<br>";

echo "<table border='1'>";
echo "<caption>[" . $src_name . "]</caption>";
echo "<caption>" . $total_word_ct['total_word'] . " words total</caption>";
//table header
echo "<thead>";
echo "<tr>";
echo "<th >Word</th>";
echo "<th >Frequency</th>";
echo "<th >Percentage</th>";
echo "</tr>";
echo "</thead>";
//table rows
while ($row = mysqli_fetch_assoc($result)) {
    $word_percent = round($row['freq'] / $total_word_ct['total_word'] * 100, 3);
    echo "<tr>";
    echo "<td>" . $row['word'] . "</td>";
    echo "<td>" . $row['freq'] . "</td>";
    echo "<td>" . $word_percent . " % </td>";
    $total_percent += $word_percent;
}
echo "</table>";
// echo "total percent:". $total_percent;
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