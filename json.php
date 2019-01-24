<?php
$ret = '';
$url = "http://1045radiolatina.com/garitas/web/garitas-responsive.php";
//$url = "http://10.168.3.154:8080/webpages/files/cv/radiolatina.html";
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
//$url = "http://10.168.3.154:8080/webpages/files/cv/tipoCambio.html";
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

/*arma json*/
$myObj = new stdClass();

$myObj->puertasSy = $garita[0];
$myObj->izquierdoSy = $garita[1];
$myObj->readylaneSy = $garita[2];
$myObj->sentriSy = $garita[3];
$myObj->peatonesSy = $garita[4];

$myObj->puertasOt = $otayGarita[0];
$myObj->izquierdoOt = $otayGarita[1];
$myObj->readylaneOt = $otayGarita[2];
$myObj->sentriOt = $otayGarita[3];
$myObj->peatonesOt = $otayGarita[4];
$myObj->tscarriln = $carrilNormal;

$myJSON = json_encode($myObj);

echo $myJSON;


?>  
