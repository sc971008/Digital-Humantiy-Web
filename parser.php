<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="Cheng Shi-1.png" >
    <title>Web-Based Text Parser</title>
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

    <section id="sec_form">
    <h2>Web-Based Text Parser</h2>
    <form id="parse_form" action="parser.php" method="post">
        <p>Source Name:</p>
        <p><input type="text" name="source_name" require="true"></p>

        <p>URL:</p>
        <p><input type="text" name="source_url" require="true"></p>

        <p>Begin (Optional):</p>
        <p><input type="text" name="source_begin" ></p>

        <p>End (Optional):</p>
        <p><input type="text" name="source_end"></p>

        <p><input type="submit" value="Parse" id="submit_button"></p>
    </form>
    </section>





    <section id="parse_result_sec">
    <h2 style="margin-left:0">Result</h2>
<!--------------------- Data base handle ----------------->
    <?php
if (($_POST['source_name'] == null || $_POST['source_url'] == null) & $_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<div>&#10060</div>";
    echo "[Invalid Input]";
    echo "<br>Must Fill in Name and Url" . $src_id;
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    insert_db();
}
function insert_db()
{
    $host = "mars.cs.qc.cuny.edu";
    $db_name = "shch5304";
    $db_port = 3306;
    $db_username = "shch5304";
    $db_password = "23375304";

    // Creating connection to mars
    $conn = mysqli_connect($host, $db_username, $db_password, $db_name, $db_port);

    //if conn failed
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    } else {
        echo "<br><div>&#9989</div>";
        echo "[DataBase Connected]";
    }

    //case: POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $src_name = $_POST["source_name"];
        $src_url = $_POST["source_url"];
        $src_begin = $_POST["source_begin"];
        $src_end = $_POST["source_end"];
        echo "<br>-Name:" . $src_name;
        echo "<br>-Url:" . $src_url;
        echo "<br>-Begin:" . $src_begin;
        echo "<br>-End:" . $src_end;
    }

    function strip_punc($string)
    {
        $string = strtoupper($string);
        $string = trim(preg_replace("/[^0-9a-z]+/i", " ", $string));
        return $string;
    }

    //-----------Parse into word frequency--------------
    $src_txtfile = file_get_contents($src_url);
    // echo "<br>src text string:".$src_txtfile;
    //chop off begin
    if ($src_begin != null) {
        $src_txtfile = strstr($src_txtfile, $src_begin);
    }

    //chop off end
    if ($src_end != null) {
        $src_txtfile = strstr($src_txtfile, $src_end, true);
    }

    //strip puncuation
    $src_txtfile = strip_punc($src_txtfile);
    // echo "<br>src after strip:".$src_txtfile;
    //chop into words array
    $words = explode(' ', $src_txtfile);
    //increments each time we read in that word
    $word_freq = array();
    foreach ($words as $word) {
        $word_freq[$word] += 1;
    }
    // echo "<br>word freq:";
    // echo '<pre>',print_r($word_freq,1),'</pre>';
    // echo print_r($word_freq);

    //------------------------insert to source--------------
    $insert_src = "INSERT INTO source(source_name , source_url , source_begin , source_end)
            VALUES('$src_name','$src_url','$src_begin','$src_end')";
    if (mysqli_query($conn, $insert_src)) {
        //get the source_id where is was inserted
        $src_id = $conn->insert_id;
        echo "<br><div>&#9989</div>";
        echo "[New Record created]";
        echo "<br>-SourceID#" . $src_id;
        echo "<br><a href='https://venus.cs.qc.cuny.edu/~shch5304/cs355/report.php'>See Parse Report</a>";
    } else {
        echo "<div>&#10060</div>";
        echo "[Error]: " . $insert_src . "<br>" . mysqli_error($conn);
    }

    //----------------------insert to occurence--------------
    foreach ($word_freq as $word => $freq) {
        $insert_occu = " INSERT INTO occurrence(source_id, word, freq)
    VALUES('$src_id','$word','$freq')";

        if (mysqli_query($conn, $insert_occu)) {
            // echo "<br>Word freq added---'$word'--'$freq'";
        } else {
            // echo "<br>Error: " . $insert_occu . "<br>" . mysqli_error($conn);
        }
    }
}
?>
<!--------------------- Data base handle ----------------->

    </section>

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