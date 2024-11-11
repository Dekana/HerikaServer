<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>

<?php

if(isset($_POST["submit"])) {
    ob_start();
    $targetDirectory = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."conf".DIRECTORY_SEPARATOR; // Specify the directory where you want to store "conf.php".
    $targetFile = $targetDirectory . "conf.php"; // Specify the name of the file you want to replace.
    
    // Try to move the uploaded file to the specified directory
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "File uploaded successfully.".PHP_EOL;
    } else {
        echo "Error uploading file.".PHP_EOL;
    }
    
    $result = ob_get_clean();
}

include("tmpl/head.html");

$debugPaneLink = false;
include("tmpl/navbar.php");

echo "<pre>$result</pre>";

echo '
<form action="conf_import.php" method="POST" enctype="multipart/form-data">
    <label for="file">Select a file:</label>
    <input type="file" name="file" id="file">
    <br>
    <input type="submit" name="submit" value="Upload">
</form>
';

include("tmpl/footer.html");
$buffer = ob_get_contents();
ob_end_clean();
$title = "CHIM";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
