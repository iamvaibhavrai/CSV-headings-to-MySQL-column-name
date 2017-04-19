<?php
// Connection To Database
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "vayam";

$connection = new mysqli($hostname,$username,$password,$dbname);
if($connection->connect_error) {
  die("Connectionn Error: " . $connection->connect_error);
}
// Connection Established

// Checking if submit Button is Clicked
if(isset($_POST['submit'])) {
  // Checking if a file is selected or not
  if($_FILES['file']['name']) {
    // Spliting the name of file from '.' in an array such that it seperates file name and extension.
    $fileName = explode('.',$_FILES['file']['name']);
    // Checking if the extension is csv or not. Checking validity of file.
    if ($fileName[1] == 'csv') {
      // Opening file
      $handle = fopen($_FILES['file']['tmp_name'],"r");
      // Getting only first row of csv file i.e column names using fgetcsv() function
      $data = fgetcsv($handle);

// data[0] represents first column of csv file
// seperating words of column names from spaces
$seperating_from_spaces = explode(" ",$data[0]);
// joining array
$joining_spaces = join("_",$seperating_from_spaces);
// seperating words of column names from dots
$seperating_from_dots = explode(".",$joining_spaces);
// joining array
$joining_dots = join("",$seperating_from_dots);
// seperating words of column names from dots
$seperating_from_dashes = explode("-",$joining_dots);
// joining array
$joining_dashes = join("",$seperating_from_dashes);
// Converting string to lowercase
$first_column = strtolower($joining_dashes);

// If your csv file columns have any other characters that mySql do not allow as column.
// Remove them using the same procedure.
// First explode with that character.
// Then join the array.

// Create table Query
// Adding first column
$q = "CREATE TABLE result($first_column INT NOT NULL";
$no_of_columns = 10;
// Running a loop from first column to total number of columns.
// First column i.e data[0] is already processed.
// So we are working from second column.
for ($i=1; $i <$no_of_columns ; $i++) {
  // All exploding and joining performed in same line.
  $dat = strtolower(join("",explode("-",join("",explode(".",join("",explode(" ",$data[$i])))))));
  // Adding comma and next column name to query.
  $q .= ",";
  $q .= $dat;
  // Adding data type of column in query.
  $q .= " VARCHAR (256)";
}
// Adding first column as primary key.
$q .= ",PRIMARY KEY($first_column));";
// Running query
$connection->query($q);
?>

<!--
For any suggestion or error leave a comment.
You can also leave me a mail at: iamvaibhavrai@gmail.com

Thanks You.
 -->
