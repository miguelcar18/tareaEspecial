<?php

function fijo()
{
    $miell=curl_init();
    curl_setopt($miell, CURLOPT_URL, "localhost/tareaEspecial/ventana.html");
    curl_setopt($miell, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($miell, CURLOPT_HTTPHEADER, array("Accept-Languaje: es-es, en"));
    curl_setopt($miell, CURLOPT_TIMEOUT, 10);
    curl_setopt($miell, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($miell, CURLOPT_RETURNTRANSFER, 1);
    $result=curl_exec($miell);
    $error=curl_error($miell);
    curl_close($miell);
    return $result;
}

function recibe_imagen ($url_origen,$archivo_destino){
    $mi_curl = curl_init ($url_origen);
    $fs_archivo = fopen ($archivo_destino, "w+");
    curl_setopt ($mi_curl, CURLOPT_FILE, $fs_archivo);
    curl_setopt ($mi_curl, CURLOPT_HEADER, 0);
    curl_exec ($mi_curl);
    curl_close ($mi_curl);
    fclose ($fs_archivo);
}

$fijo=fijo();
//Titulo
preg_match_all('(<strong id="titulo">(.*)</strong>)siU',$fijo, $subject01);
//Descripcion
preg_match_all('(<td id="descripcion">(.*)</td>)siU',$fijo, $subject02);
//Imagen
preg_match_all('(<img src="(.*)" width="(.*)" height="(.*)" />)siU',$fijo, $subject03);

$direccionUrl="localhost/tareaEspecial/";
$contador01=count($subject01);
$carpeta="uploads/";
/*$contador02=count($subject02)+1;
$contador03=count($subject03)+1;*/

for($i=0; $i<=$contador01; $i++)
{
    $titulo= 'Este es el titulo '.$i.': '.$subject01[1][$i].'<br>';
    $descripcion='Este es la descripcion '.$i.': '.$subject02[1][$i].'<br>';
    $urlImagen=$direccionUrl.$subject03[1][$i];
    $contadorUbicarImagen=count(explode("/", $subject03[1][$i]));
    $ubicarImagen=explode("/", $subject03[1][$i]);
    $imagenDestino=$carpeta.$ubicarImagen[$contadorUbicarImagen-1];
    $imagen='La ubicacion de la imagen '.$i.' es: '.$urlImagen.'<br><br>';
    ini_set('max_execution_time', 300);
    recibe_imagen($urlImagen,$imagenDestino);
    echo $titulo.$descripcion.$imagen;
}
?>
