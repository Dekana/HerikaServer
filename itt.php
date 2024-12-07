<?php


/* STT entry point */


$path = dirname((__FILE__)) . DIRECTORY_SEPARATOR;
require_once($path . "conf".DIRECTORY_SEPARATOR."conf.php"); // API KEY must be there
require_once($path . "lib" .DIRECTORY_SEPARATOR."model_dynmodel.php");
require_once($path . "lib" .DIRECTORY_SEPARATOR."{$GLOBALS["DBDRIVER"]}.class.php");
require_once($path . "lib" .DIRECTORY_SEPARATOR."data_functions.php");
require_once($path . "lib" .DIRECTORY_SEPARATOR."chat_helper_functions.php");

if (isset($_GET["format"]) && $_GET["format"]=="png")
    $finalName=__DIR__.DIRECTORY_SEPARATOR."soundcache/_img_".md5($_FILES["file"]["tmp_name"]).".png";
else
    $finalName=__DIR__.DIRECTORY_SEPARATOR."soundcache/_img_".md5($_FILES["file"]["tmp_name"]).".bmp";


if (!$_FILES["file"]["tmp_name"]) {
    error_log("ITT error, no data given: ".print_r($_POST,true));
    die("ITT error, no data given");
    
}
@copy($_FILES["file"]["tmp_name"] ,$finalName);


if (isset($_GET["profile"])) {
    if (file_exists($path . "conf".DIRECTORY_SEPARATOR."conf_{$_GET["profile"]}.php")) {
       // error_log("PROFILE: {$_GET["profile"]}");
        require_once($path . "conf".DIRECTORY_SEPARATOR."conf_{$_GET["profile"]}.php");

    }
    $GLOBALS["CURRENT_CONNECTOR"]=DMgetCurrentModel();

}

function convertImage($originalImage, $outputImage, $quality)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.',$originalImage);
    $ext = $exploded[count($exploded) - 1]; 

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    if (!isset($_GET["format"]) || (!$_GET["format"]=="png"))
        imageflip($imageTmp, IMG_FLIP_VERTICAL);

    // quality is a value from 0 (worst) to 100 (best)
    //imagepng($imageTmp, $outputImage, $quality);
    imagejpeg($imageTmp, $outputImage, $GLOBALS["FEATURES"]["MISC"]["ITT_QUALITY"]);
    imagedestroy($imageTmp);

    return 1;
}

if (isset($_GET["format"]) && $_GET["format"]=="png")
    $finalNameJpeg=strtr($finalName,[".png"=>".jpg","_img_"=>"_img_p_"]);
else
    $finalNameJpeg=strtr($finalName,[".bmp"=>".jpg","_img_"=>"_img_p_"]);

error_log("Saving $finalName to $finalNameJpeg");
convertImage($finalName,$finalNameJpeg,9);
@unlink($finalName);


 
$db=new sql();
$location=DataLastKnownLocation();
$hints="";
//$charactersArray=implode(",",DataPosibleInspectTargets(true));

if (isset($_GET["vc"])) {
    $sanitize=explode(",",$_GET["vc"]);
    $vc=[];
    foreach ($sanitize as $name) {
        if (!empty(trim($name)))
           $vc[]=ucfirst($name); 
    }
    
    $hints.="Visible characters: ".implode(",",$vc)."\n";
}
if (isset($_GET["fg"])) {
    $hints.="Foreground characters:{$_GET["fg"]}.\n";
}

$hints.="Location: $location";

require_once($path."itt/itt-{$GLOBALS["ITTFUNCTION"]}.php");

echo itt($finalNameJpeg,$hints);


?>
