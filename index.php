<?php
	$conexion=mysql_connect('localhost','root','') or die("error al ejecutar la conexion");
	mysql_select_db('asamblea',$conexion);

	//*************
	if(isset($_POST['action']))
	{
		$nameEXCEL = $_FILES['deceval']['name'];
		$tmpEXCEL = $_FILES['deceval']['tmp_name'];
		$extEXCEL = pathinfo($nameEXCEL);
		$urlnueva = "xls/".$nameEXCEL."";			
		if(is_uploaded_file($tmpEXCEL)){
			copy($tmpEXCEL,$urlnueva);	
			
		}
		echo $nameEXCEL;
	}
	else{
		echo "Cargar un archivo para llenar la BD";
	}

	
			$valores="";
		if(isset($_POST['action'])){
			require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
			
			$objPHPExcel = PHPExcel_IOFactory::load('xls/'.$nameEXCEL);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true);
	
			foreach ($objHoja as $iIndice=>$objCelda) {

				$nCuenta=$objCelda['A'];		$nomInversionista=$objCelda['B'];
				$identificacion=$objCelda['E'];	$tipoIdentificacion=$objCelda['G'];
				$tipoRelacion=$objCelda['K'];	$mancomunado1=$objCelda['L'];
				$mancomunado2=$objCelda['O'];	$mancomunado3=$objCelda['R'];	
				$mancomunado4=$objCelda['U'];	

					
			    	$valores.="(".$nCuenta.",'".$nomInversionista."','".$identificacion."',".$tipoIdentificacion.",'".$tipoRelacion."','".$mancomunado1."','".$mancomunado2."','".$mancomunado3."','".$mancomunado4."'),";

				
				}
				$valores=trim($valores,',');
				$sql="INSERT INTO `asamblea`.`deceval` (`nCuenta`, `nomInversinista`, `identificacion`, `tipoIdentificacion`, `tipoRelacion`, `mancomunado1`, `mancomunado2`, `mancomunado3`, `mancomunado4`) VALUES ".$valores;

				mysql_query($sql)or die(mysql_error()) ;
				echo 'Datos Actualizados con Exito';
			}
?>
<!DOCTYPE html>
<html>
<head>
	<title>cargar deceval</title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data" name="carga-excel">
		<label></label><input type="file" name="deceval"><br>
		<input type="submit" value="cargar a la base de datos">
		<input type="hidden" value="upload" name="action">
	</form>
</body>
</html>
