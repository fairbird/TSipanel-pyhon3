<?php
$_GET['xml']="UPDATE";
date_default_timezone_set("Europe/Paris");

function formatbytes($file, $type)
{
   switch($type){
      case "KB":
         $filesize = filesize($file) * .0009765625; // bytes to KB
      break;
      case "MB":
         $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
      break;
      case "GB":
         $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
      break;
   }
   if($filesize <= 0){
      return $filesize = 'unknown file size';}
   else{return round($filesize, 2).' '.$type;}
}

function prepend($string, $filename) {
    if ($string=='Basic-b'){
		   return;
			 }
		$string=lcfirst($string);
    file_put_contents($filename, $string.",", FILE_APPEND | LOCK_EX);
}
function endsWith( $str, $sub ) {
    return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
 }
 
function fileexists( $path ) {
    return (file_exists($path) === TRUE);
	
 }
function isfile( $path ) {
    return (is_file($path) === TRUE);
	
 }
$dirserv='https://github.com/fairbird/TSipanel-pyhon3/raw/main';

header("Content-type: text/xml");
$value='../TSipanel-pyhon3/new_addons';
if (fileexists($value)) {
        unlink($value);
		}
$value2='../TSipanel-pyhon3/updated_addons';
if (fileexists($value2)) {
        unlink($value2);
		}		
$value3='../TSipanel-pyhon3/software_fix';
if (fileexists($value3)) {
        unlink($value3);
		}

$value4='../TSipanel-pyhon3/stopped_addons';
if (fileexists($value4)) {
        unlink($value4);
		}			
if(@$_GET['xml'] == 'UPDATE'){
	$nombre_archivo = '../TSipanel-pyhon3/TSipanel.xml'; $fp = fopen($nombre_archivo,"w"); fclose($fp);
	$arr = Array('bootlogo', 'Cams-arm', 'Cams-mips', 'Icons-Panel', 'Icons-Panel-FHD', 'Picons', 'Plugins','Plugins-Backup','Plugins-Epg','Plugins-IPTV','Plugins-Multiboot','Plugins-Vpn','Plugins-Weather');
	XML($nombre_archivo, $dirserv, $arr);
}


function XML($nombre_archivo, $dirserv, $arr){
$num=0;
$i=0;
$newfiles=False;
$updatedaddons="";
$newaddons="";
$files=array();
$init_xml='<xml>';

foreach ($arr as &$dir) {

$dirss=$arr[$num];

$dr=@opendir($dir);


	if(!$dr){
		echo "<error/>";
		exit;
	}else{
        
		echo $init_xml.'<plugins cont="'.str_replace("plugin", " ",str_replace("_", " ",str_replace("/", "",$dirss))).'">';
		$contenido2 = $init_xml.'<plugins cont="'.str_replace("plugin", " ",str_replace("_", " ",str_replace("/", "",$dirss))).'">';

		while (($archivo = readdir($dr)) !== false) {
          
		  if($archivo!='.' && $archivo!='..'){
			if (endsWith($archivo,'.txt') !== TRUE){
              if (endsWith($archivo,'.jpg') !== TRUE){
                echo $archivo;
				$archivop = str_replace(".ipk", ".jpg",str_replace(".tar.bz2", ".jpg",str_replace(".tar.gz", ".jpg",str_replace(".zip", ".jpg",str_replace(".tar.bz2", ".jpg",str_replace(".tbz2", ".jpg",$archivo))))));
				$archivot = str_replace(".ipk", ".txt",str_replace(".tar.bz2", ".txt",str_replace(".tar.gz", ".txt",str_replace(".zip", ".txt",str_replace(".tar.bz2", ".txt",str_replace(".tbz2", ".txt",$archivo))))));
				
                $archivo2 = str_replace("plugin-", "",str_replace("enigma2-", "",str_replace(".tar.gz", "",str_replace(".zip", "",str_replace("_mipsel", "",str_replace("extensions-", "",str_replace("systemplugins-", "",str_replace(".ipk", "",str_replace(".tbz2", "",str_replace(".tar.bz2", "",$archivo))))))))));
                
				$archivo2 = ucwords($archivo2);
				$archivop='../TSipanel-pyhon3/'.$dir.'/'.$archivop;
				$archivod='../TSipanel-pyhon3/'.$dir.'/'.$archivo;
				
				if (fileexists($archivop) == TRUE){
				      $archivo2 .= '-p';
				   
				   }
				$archivot='../TSipanel-pyhon3/'.$dir.'/'.$archivot;  
				if (fileexists($archivot) == TRUE){
				      $archivo2 .= '-d';
				   
				   }
				if (endsWith($archivo2,'-p-d') == TRUE){
				    $archivo2=str_replace("-p-d", "-b",$archivo2);
				
				}
				if (endsWith($archivo2,'-p-p') == TRUE){
				    $archivo2=str_replace("-p-p", "-p",$archivo2);
				
				}
				if (endsWith($archivo2,'-d-d') == TRUE){
				    $archivo2=str_replace("-d-d", "-d",$archivo2);
				
				}
				if (endsWith($archivo2,'-b-b') == TRUE){
				    $archivo2=str_replace("-b-b", "-b",$archivo2);
				
				}
				if (endsWith($archivo2,'-d-p') == TRUE){
				    $archivo2=str_replace("-d-p", "-p",$archivo2);
				
				}
				$filesize=formatbytes($archivod,"KB");
				$archivename=$archivo2;

				$datemonth=Date('m');
				
				
				echo "<plugin name='$archivo2'><url>$dirserv/$dir/$archivo</url><filesize>$filesize</filesize></plugin>";
				$contenido = $contenido2."<plugin name='$archivo2'><url>$dirserv/$dir/$archivo</url><filesize>$filesize</filesize></plugin>";
                $contenido2 ="";

				if (is_writable($nombre_archivo)) {

    				if (!$gestor = fopen($nombre_archivo, 'a')) {
         				echo "No se puede abrir el archivo ($nombre_archivo)";
         			exit;
    				}

   				 	if (fwrite($gestor, $contenido) === FALSE) {
        				echo "No se puede escribir en el archivo ($nombre_archivo)";
        			exit;
    				}

				}else{
    				echo "El archivo $nombre_archivo no es escribible";
				}
			}	
          }
		 } 
		     	 
         
	}
$init_xml='';
echo '</plugins>';
$contenido = "</plugins>";
	if (fwrite($gestor, $contenido) === FALSE) {
		echo "No se puede escribir en el archivo ($nombre_archivo)";
		exit;
	}
closedir($dr);
$num++;
}
}


echo "</xml>";
$contenido = "</xml>";

	if (fwrite($gestor, $contenido) === FALSE) {
		echo "No se puede escribir en el archivo ($nombre_archivo)";
		exit;
	}


fclose($gestor);
if ($newfiles == FALSE) {
    exit;
}	
$newvalue = $nowdate;
    foreach($files as $key => $value){
        $newvalue .= ';'.$value;    
           
    }
	$newvalue .= ';'."------------------------------------------------------------";
if (fileexists('../TSipanel-pyhon3/TSipanel-updates/'.$datemonth.'.txt') == TRUE){
	    $array2=file('../TSipanel-pyhon3/TSipanel-updates/'.$datemonth.'.txt');
	}else{
        $array2=($nowdate.";"."No new plguins");
        $old = '../TSipanel-pyhon3/Tunisiasataddons2.txt';
		$Datad=$nowdate.";"."No new plguins";
		$prevmonth=$datemonth-1;
		$premonthname .= 'Tunisiasataddons2'.$prevmonth;
		$new = '../TSipanel-pyhon3/TSipanel-updates/'.$premonthname.'.txt';
        copy($old, $new);		
        $fpd=fopen('../TSipanel-pyhon3/TSipanel-updates/'.$datemonth.'.txt',"w");
		fwrite($fpd, $Datad);
        fclose($fpd);		
    }
$firstline=$array2[0];
$newvalue = trim($newvalue);
$fp=fopen('../TSipanel-pyhon3/TSipanel-updates/'.$datemonth.'.txt',"w");
$arr2=explode(';', $firstline);
    if($arr2[0]==$nowdate){
			$array2[0]= $newvalue;
	}else{
	    if($newvalue != '') 
    {
         fwrite($fp,$newvalue."\n");	
    }
            
	}
$newvalue='';

    
    

    foreach($array2 as $key => $value){
	   $value=trim($value);
	    if($value != '') 
       {
         fwrite($fp,$value."\n");	
       }
		      
            
    }
	
    fclose($fp);
$array1=file('../TSipanel-pyhon3/TSipanel-updates/'.$datemonth.'.txt');

for ($d = 0; $d<count($array1); $d++) {
  
    $onestring =  $array1[$d];
	$newstring .=  $onestring;
  
}
$arr=explode(';', $newstring);
$datestr = $arr[0];

for ($m = 0; $m<count($arr); $m++) {
    if($m == 0){
			$tstring = $arr[$m];
	        
	}else{
	    $tstring =  $arr[$m];
	    
    }
    $totstring .=  $tstring."\n\n";
  
}
$totstring = trim($totstring);
$tunisiastr ="**TSipanel server updates**\n**Managed by RAED**\n**Tunisia-sat.com\n -----------------------------------------------------";
$File = '../TSipanel-pyhon3/TSipanel.txt'; 
$Handle = fopen($File, 'w');
$Data = $tunisiastr."\n".$totstring; 
fwrite($Handle, $Data);
fclose($Handle);

}


?>
