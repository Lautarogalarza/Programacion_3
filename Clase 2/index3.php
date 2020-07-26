<?php

//copy("archivo.txt","archivo2.txt");//copia el contenido de un archivo a otro
$archivo =fopen("archivo.txt","a+");
unlink("archivo2.txt");

//echo fread($archivo,filesize("archivo.txt"));//leo todo el archivo hasta el final

$bytes=fwrite($archivo,"Nueva linea");

while (!feof($archivo)) {//leo linea por linea
   echo fgets($archivo);
}

$cerrar=fclose($archivo);

?>