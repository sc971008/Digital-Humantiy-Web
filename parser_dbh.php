<?php

$host = "mars.cs.qc.cuny.edu";
$db_name = "shch5304";
$db_port= 3306;
$db_username = "shch5304";
$db_password = "23375304";

// Creating connection to mars
$conn = mysqli_connect($host,$db_username,$db_password,$db_name,$db_port);

//if conn failed
if ($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
}
else echo "<br>DB Connected successfully";

//case: POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $src_name = $_POST["source_name"];
    $src_url = $_POST["source_url"];
    $src_begin = $_POST["source_begin"];
    $src_end = $_POST["source_end"];
    echo "<br>src_name:".$src_name;
    echo "<br>src_url:".$src_url;
    echo "<br>src_begin:".$src_begin;
    echo "<br>src_end:".$src_end;
}

function strip_punc($string) {
    $string = strtoupper($string);
    $string = trim(preg_replace("/[^0-9a-z]+/i", " ", $string));
    return $string;
}

//-----------Parse into word frequency--------------
$src_txtfile = file_get_contents($src_url);
// echo "<br>src text string:".$src_txtfile;
//chop off begin
if($src_begin!=null) $src_txtfile = strstr($src_txtfile,$src_begin);
//chop off end
if($src_end!=null) $src_txtfile = strstr($src_txtfile,$src_end,true);
//strip puncuation
$src_txtfile=strip_punc($src_txtfile);
// echo "<br>src after strip:".$src_txtfile;
//chop into words array
$words = explode(' ',$src_txtfile);
//increments each time we read in that word
$word_freq = array();
foreach($words as $word){
    $word_freq[$word] +=1;
}


// echo "<br>word freq:";
// echo '<pre>',print_r($word_freq,1),'</pre>';
// echo print_r($word_freq);

//insert to source
$insert_src="INSERT INTO source(source_name , source_url , source_begin , source_end) 
            VALUES('$src_name','$src_url','$src_begin','$src_end')";
if (mysqli_query($conn, $insert_src)) {
    echo "<br>New record created successfully";
    //get the source_id where is was inserted
    $src_id = $conn->insert_id;
    echo "<br>ADD INTO Src ID----".$src_id;
} 
else {
    echo "<br>Error: " . $insert_src . "<br>" . mysqli_error($conn);
}

//insert to occurence
foreach($word_freq as $word =>$freq){
    $insert_occu= " INSERT INTO occurrence(source_id, word, freq) 
    VALUES('$src_id','$word','$freq')";

    if (mysqli_query($conn, $insert_occu)) {
        echo "<br>Word freq added---'$word'--'$freq'";
    } 
    else {
        echo "<br>Error: " . $insert_occu . "<br>" . mysqli_error($conn);
    }
}
?>
