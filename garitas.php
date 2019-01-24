<?php
$archivo = "contador.txt"; // Archivo en donde se acumulará el numero de visitas
$abre = fopen($archivo, "r"); // Abrimos el archivo para solamente leerlo (r de read)
$total = fread($abre, filesize($archivo)); // Leemos el contenido del archivo(filesize "detectara" la longitud de Bytes de $archivo la cual desconocemos)
fclose($abre); // Cerramos la conexión al archivo
$abre = fopen($archivo, "w"); // Abrimos nuevamente el archivo (w de write)
$total = $total + 1; // Sumamos 1 nueva visita
$grabar = fwrite($abre, $total); // Y reemplazamos por la nueva cantidad de visitas
fclose($abre); // Cerramos la conexión al archivo
  

date_default_timezone_set('UTC'); 
setlocale(LC_ALL,"es_MX.UTF-8");
$tiempo = strftime("%A %d de %B del %Y");
$diaS = date("N");
$diaM = strftime("%d");
$nMes = date("m");
$year = strftime("%Y");

$diaSemana = array( "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
$Mes = array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

  
$ret = '';
$url = "http://1045radiolatina.com/garitas/web/garitas-responsive.php";
$ret = file_get_contents($url);
$ysi = strpos($ret,"San Ysidro:");
$ota = strpos($ret,"Otay:");
$resul = $ota-$ysi;

$ysidro =  substr($ret,$ysi,$resul);
$otay = substr($ret,$ota);

$Ypue = strpos($ysidro,"Puertas:");
$Yizq = strpos($ysidro,"Izquierdo:");
$Yrea = strpos($ysidro,"Ready Lane:");
$Ysen = strpos($ysidro,"Sentri:");
$Ypea = strpos($ysidro,"Peatones:");

$garita = array();
$x=0;
$valor='';
for($x=0; $x<=4; $x++){
	if($x==0){
		$resul = $Yizq-$Ypue;
		$valor = substr($ysidro,$Ypue,$resul);
	}
	if($x==1){
		$resul = $Yrea-$Yizq;
		$valor = substr($ysidro,$Yizq,$resul);
	}
	if($x==2){
		$resul = $Ysen-$Yrea;
		$valor = substr($ysidro,$Yrea,$resul);
	}
	if($x==3){
		$resul = $Ypea-$Ysen;
		$valor = substr($ysidro,$Ysen,$resul);
	}
	if($x==4){
		$valor = substr($ysidro,$Ypea);
	}
	$from = strpos($valor,"cantidad");
	$to = strpos($valor,"</sp");
	$resul = $to-$from;
	$garita [$x] = substr($valor,$from+10,$resul-10);
}

$Opue = strpos($otay,"Puertas:");
$Oizq = strpos($otay,"Normales:");
$Orea = strpos($otay,"Ready Lane:");
$Osen = strpos($otay,"Sentri:");
$Opea = strpos($otay,"Peatones:");

$otayGarita = array();

$y=0;
  for($y=0; $y<=4; $y++){
	if($y==0){
		$resul = $Oizq-$Opue;
		$valor = substr($otay,$Opue,$resul);
	}
	if($y==1){
		$resul = $Orea-$Oizq;
		$valor = substr($otay,$Oizq,$resul);
	}
	if($y==2){
		$resul = $Osen-$Orea;
		$valor = substr($otay,$Orea,$resul);
	}
	if($y==3){
		$resul = $Opea-$Osen;
		$valor = substr($otay,$Osen,$resul);
	}
	if($y==4){
		$valor = substr($otay,$Opea);
	}
	$from = strpos($valor,"cantidad");
	$to = strpos($valor,"</sp");
	$resul = $to-$from;
	$otayGarita [$y] = substr($valor,$from+10,$resul-10);	
}


$url = "http://garitasreporte.com";
$ret = file_get_contents($url);
$com = strpos($ret,"Compra:");
$ven = strpos($ret,"Venta:");
$compra = substr($ret,$com+7,13);
$venta = trim(substr($ret,$ven+7,13));

$cruceSan = strpos($ret,">Garita San Ysidro");
$pedw = strpos($ret, "PedWest");
$gariOtay = strpos($ret,"Garita Otay");
$resul = $pedw-$cruceSan;
$passenger = substr($ret,$cruceSan,$resul);
$len = strlen($passenger);
$carrilN = strpos($passenger,"carrilNormalTiempo");
$sanYR = strpos($passenger,"carrilReadyLaneTiempo");
$sanYSen = strpos($passenger,"carrilSentriTiempo");
$sanYApie = strpos($passenger,"peatonalTiempo");
$resul = $sanYR-$carrilN;
$carrilNormal = substr($passenger,$carrilN+20,$resul-36);
$resul = $sanYSen-$sanYR;
$carrilReadyLane = substr($passenger,$sanYR+23,$resul-39);
$resul = $sanYApie-$sanYSen;
$carrilSentri = substr($passenger,$sanYSen+20,$resul-36);
$resul = $len-$sanYApie;
$sanYsidroPeaton = substr($passenger,$sanYApie+16,$resul-1400);


$resul =  $gariOtay-$pedw;
$passenger = substr($ret,$pedw,$resul);
$len = strlen($passenger);
$pWest = strpos($passenger,"peatonalTiempo");
$resul = $len-$pWest;
$pedWest = substr($passenger,$pWest+16,$resul-115);

$ped = strpos($ret,"Express");
$resul = $ped-$gariOtay;
$passenger = substr($ret,$gariOtay,$resul);
$len = strlen($passenger);
$otayNorm = strpos($passenger,"carrilNormalTiempo");
$otayR = strpos($passenger,"carrilReadyLaneTiempo");
$otaySen = strpos($passenger,"carrilSentriTiempo");
$otayApie = strpos($passenger,"peatonalTiempo");
$resul = $otayR-$otayNorm;
$otayNormal = substr($passenger,$otayNorm+20,$resul-36);
$resul = $otaySen-$otayR;
$otayReady = substr($passenger,$otayR+23,$resul-39);
$resul = $otayApie-$otaySen;
$otaySentri = substr($passenger,$otaySen+20,$resul-36);
$resul = $len-$otayApie;
$otayPeaton = substr($passenger,$otayApie+16,$resul-98);





?>  
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="garita, garitas, reporte garitas, garita tijuana, garita san ysidro, tijuana, linea otay">
<title>Reporte de Garitas</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<script>
function startTime() {
	var month = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Ago", "Sep", "Nov", "Dic"];
	var dia = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var Mes = today.getMonth();
    var year = today.getFullYear();
    var day = today.getDate();
	var dayofw = today.getDay();
	var diasemana = dia[dayofw-1];
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('hora').innerHTML = h + ":" + m + ":" + s;
    document.getElementById("fecha").innerHTML = day +"/"+ month[Mes-1] +"/"+ year; 
	document.getElementById("diaSemana").innerHTML = diasemana;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
</head>
<body class="w3-light-grey" onload="startTime()">
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
  <span class="w3-bar-item w3-right">Trafico de Garitas</span>
</div>
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index: 3; width: 300px; display: none;" id="mySidebar"><br>
<div class="w3-bar-block">
      <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
</div>
  <div class="w3-container w3-row">
    <div class="w3-col s2"></div>
    <div class="w3-col s10 w3-bar">
    	<h5><b id="diaSemana"></b> <b id="fecha"></b></h5><h5><b id="hora"></b></h5>
      	<h5><span>Tipo de cambio</span></h5>
		<span>Compra: <strong><?php echo $compra?></strong></span><br>
     	<span>Venta: <strong><?php echo $venta?></strong></span><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Trafico Garitas</h5>
  </div>
  <div class="w3-bar-block">

    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>&nbsp; Tijuana</a>
<!--     <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>&nbsp; Tecate</a> -->
<!--     <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>&nbsp; Mexicali</a> -->
  </div>
</nav>
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor: pointer; display: none;" title="close side menu" id="myOverlay"></div>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:40px">
    <h5><b><i class="fa fa-map-signs"></i> Garita de San Ysidro</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $garita[0]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Puertas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $garita[1]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Izquierdo</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $garita[2]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ready Lane</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-pink w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $garita[3]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Sentri</h4>
      </div>
    </div>
    <div>.</div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $garita[4]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Peatones</h4>
      </div>
    </div>
	<div class="w3-quarter">
      <div class="w3-container w3-dark-gray w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Peatones PedWest</h4>
      </div>
    </div>
  </div>
	
  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Ubicacion</h5>
        <div id="googleMap" style="width:100%;height:200px;">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6726.922346871836!2d-117.03345872182425!3d32.54053513016391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7e202df1349fb0ee!2sU.S.+Customs+and+Border+Protection+-+San+Ysidro+Port+of+Entry!5e0!3m2!1ses-419!2smx!4v1505258075178" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
      </div>
      <div class="w3-twothird">
        <h5>Tiempo Aproximado de Espera</h5>
        <table class="w3-table w3-striped w3-white">
          <tbody>
		  <tr>
            <td><i class="fa fa-car w3-text-black w3-large"></i></td>
            <td>Lineas Normales.</td>
            <td><i><?php echo $carrilNormal?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-car w3-text-black w3-large"></i></td>
            <td>Ready Lane.</td>
            <td><i><?php echo $carrilReadyLane?> </i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-black w3-large"></i></td>
            <td>Sentri Lane</td>
            <td><i><?php echo $carrilSentri?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-black w3-large"></i></td>
            <td>Cruce Peatonal</td>
            <td><i><?php echo $sanYsidroPeaton?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-black w3-large"></i></td>
            <td>PedWest</td>
            <td><i><?php echo $pedWest?></i></td>
          </tr>
          </tbody>
		</table>
      </div>
    </div>
  </div>	
  
  <header class="w3-container" style="padding-top:22px">
  	<h5><b><i class="fa fa-map-signs"></i> Garita de Otay</b></h5>
  </header>	
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-indigo w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $otayGarita[0]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Puertas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-cyan w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $otayGarita[1]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Normal</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-purple w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $otayGarita[2]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ready Lane</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-car w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $otayGarita[3]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Sentri</h4>
      </div>
    </div>
	    <div>.</div>
    <div class="w3-quarter">
      <div class="w3-container w3-black w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $otayGarita[4]?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Peatones</h4>
      </div>
    </div>
  </div>
    <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Ubicacion</h5>
        <div id="googleMap" style="width:100%;height:200px;">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4756.25162050121!2d-116.94124377087383!3d32.548100415299025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbe081ad2a0f7b6ab!2sU+S+A-+M+X+BORDER+CROSSING+OTAY!5e0!3m2!1ses-419!2smx!4v1505263360959" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
      </div>
      <div class="w3-twothird">
        <h5>Tiempo Aproximado de Espera</h5>
        <table class="w3-table w3-striped w3-white">
          <tbody>
		  <tr>
            <td><i class="fa fa-car w3-text-black w3-large"></i></td>
            <td>Lineas Normales</td>
            <td><i><?php echo $otayNormal?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-car w3-text-black w3-large"></i></td>
            <td>Ready Lane</td>
            <td><i><?php echo $otayReady?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-black w3-large"></i></td>
            <td>Sentri Lane</td>
            <td><i><?php echo $otaySentri?></i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-black w3-large"></i></td>
            <td>Cruce Peatonal</td>
            <td><i><?php echo $otayPeaton?></i></td>
          </tr>
          </tbody>
		</table>
      </div>
    </div>
  </div>	
  <hr>


  <hr>

  <hr>

  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Publicidad</h5>
        <p>Anunciate</p>
        <p>Noticias</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">Mantente Conectado</h5>
        <p><p><i class="fa fa-facebook" style="font-size:20px;"></i></p>
        <p><p><i class="fa fa-instagram" style="font-size:20px;"></i></p>
        <p><p><i class="fa fa-youtube" style="font-size:20px;"></i></p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Nosotros</h5>
        <p>Contacto</p>
        <p>Acerca de</p>
		<p>Comentarios</p>
      </div>
    </div>
  </div>
  <br>
   <div class="w3-container w3-black w3-padding-32">
    <div class="w3-row ">
      <div class="w3-container">
        <h5 class="w3-bottombar w3-border-red">Tipo de Cambio </h5>
        <p><?php echo "Hoy ".$diaSemana[$diaS-1]." ".$diaM." de ".$Mes[$nMes-1]." del ".$year?></p>
        <p>Compra: <?php echo $compra?> </p><p>Venta: <?php echo $venta?></p>
      </div>
    </div>
  </div>

<!--<div id="h"><textarea class="" rows="50" cols="150" id=""></textarea></div>-->
  <!-- Footer -->
  <footer class="w3-container w3-center w3-padding-16 w3-light-grey">
	<?php
	echo "<p>".$total."</p>";
	?>
    <!--<p><i class="fa fa-bitcoin" style="font-size:40px;"></i></p>-->
  </footer>

  <!-- End page content -->
</div>
<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
	
</html>
