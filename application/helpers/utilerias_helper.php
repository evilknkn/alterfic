<?php
	
	function rangeDownload($file) {
 
	$fp = @fopen($file, 'rb');
 
	$size   = filesize($file); // File size
	$length = $size;           // Content length
	$start  = 0;               // Start byte
	$end    = $size - 1;       // End byte
	// Now that we've gotten so far without errors we send the accept range header
	/* At the moment we only support single ranges.
	 * Multiple ranges requires some more work to ensure it works correctly
	 * and comply with the spesifications: http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
	 *
	 * Multirange support annouces itself with:
	 * header('Accept-Ranges: bytes');
	 *
	 * Multirange content must be sent with multipart/byteranges mediatype,
	 * (mediatype = mimetype)
	 * as well as a boundry header to indicate the various chunks of data.
	 */
	header("Accept-Ranges: 0-$length");
	// header('Accept-Ranges: bytes');
	// multipart/byteranges
	// http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
	if (isset($_SERVER['HTTP_RANGE'])) {
 
		$c_start = $start;
		$c_end   = $end;
		// Extract the range string
		list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
		// Make sure the client hasn't sent us a multibyte range
		if (strpos($range, ',') !== false) {
 
			// (?) Shoud this be issued here, or should the first
			// range be used? Or should the header be ignored and
			// we output the whole content?
			header('HTTP/1.1 416 Requested Range Not Satisfiable');
			header("Content-Range: bytes $start-$end/$size");
			// (?) Echo some info to the client?
			exit;
		}
		// If the range starts with an '-' we start from the beginning
		// If not, we forward the file pointer
		// And make sure to get the end byte if spesified
		if ($range0 == '-') {
 
			// The n-number of the last bytes is requested
			$c_start = $size - substr($range, 1);
		}
		else {
 
			$range  = explode('-', $range);
			$c_start = $range[0];
			$c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
		}
		/* Check the range and make sure it's treated according to the specs.
		 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
		 */
		// End bytes can not be larger than $end.
		$c_end = ($c_end > $end) ? $end : $c_end;
		// Validate the requested range and return an error if it's not correct.
		if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
 
			header('HTTP/1.1 416 Requested Range Not Satisfiable');
			header("Content-Range: bytes $start-$end/$size");
			// (?) Echo some info to the client?
			exit;
		}
		$start  = $c_start;
		$end    = $c_end;
		$length = $end - $start + 1; // Calculate new content length
		fseek($fp, $start);
		header('HTTP/1.1 206 Partial Content');
	}
	// Notify the client the byte range we'll be outputting
	header("Content-Range: bytes $start-$end/$size");
	header("Content-Length: $length");
 
	// Start buffered download
	$buffer = 1024 * 8;
	while(!feof($fp) && ($p = ftell($fp)) <= $end) {
 
		if ($p + $buffer > $end) {
 
			// In case we're only outputtin a chunk, make sure we don't
			// read past the length
			$buffer = $end - $p + 1;
		}
		set_time_limit(0); // Reset time limit for big files
		echo fread($fp, $buffer);
		flush(); // Free up memory. Otherwise large files will trigger PHP's memory limit.
	}
 
	fclose($fp);
 
}

	function encriptar_url($dato, $encrypt)
	{
		$resultado = $encrypt->encode($dato);
		$resultado = str_replace('/', '_', $resultado);
		$resultado = str_replace('+', '-', $resultado);
		return urlencode($resultado);
	}

	function desencriptar_url($dato, $encrypt)
	{
		$resultado = urldecode($dato);
		$resultado = str_replace('_', '/', $resultado);
		$resultado = str_replace('-', '+', $resultado);
		$resultado = $encrypt->decode($resultado);
		return $resultado;
	}
	
	function ocultar_digitos_tdc($numero) {
		$largo = strlen($numero);
		$resultado = '';
		for($i=0; $i<$largo; $i++) {
			if( $largo-4 > $i) {
				$resultado.= '*';
			} else {
				$resultado.= substr($numero, $i, 1);
			} 
		}
		return $resultado;
	}

	function numero_contrato($serie, $numero) {
		if($serie < 10) {
			return $serie.'-000000'.$numero;
		} else if($serie < 100) {
			return $serie.'-00000'.$numero;
		} else if($serie < 1000) {
			return $serie.'-0000'.$numero;
		} else if($serie < 10000) {
			return $serie.'-000'.$numero;
		} else if($serie < 100000) {
			return $serie.'-00'.$numero;
		} else if($serie < 1000000) {
			return $serie.'-0'.$numero;
		} else {
			return $serie.'-'.$numero;
		}
	}

	function texto_aleatorio ($long = 5, $letras_min = true, $letras_max = true, $num = true) {
		$salt = $letras_min?'abchefghknpqrstuvwxyz':'';
		$salt .= $letras_max?'ACDEFHKNPRSTUVWXYZ':'';
		$salt .= $num?(strlen($salt)?'2345679':'0123456789'):'';
 
		if (strlen($salt) == 0) {
			return '';
		}
 
		$i = 0;
		$str = '';
		 
		srand((double)microtime()*1000000);
 
		while ($i < $long) {
			$num = rand(0, strlen($salt)-1);
			$str .= substr($salt, $num, 1);
			$i++;
		}
		 
		return $str;
	}
	
	function es_entero($valor)
	{
		try
		{
			$valor = (int)$valor;
			return TRUE;
		}
		catch(Exception $ex)
		{
			return FALSE;
		}
		
	}
	
	function es_flotante($numero) {
		$numero = (double)$numero;
		if(is_double($numero)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function es_fecha($fecha)
	{
		$entero = str_replace("-", "", $fecha);
		if(es_entero($entero))
		{
			$explode = explode("-", $fecha);
			if(count($explode) == 3)
			{
				$anio = (string)$explode[2];
				$mes = (string)$explode[1];
				$dia = (string)$explode[0];
				if(strlen($anio) == 4 && strlen($mes)==2 && strlen($dia)==2)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	function dia_semana($fecha)
	{
		$explode = explode("/", $fecha);
		$dia = '';
		$date = date('w', mktime(0, 0, 0, $explode[1], $explode[0], $explode[2]));
		switch ( $date ) {
			case 0:
				$dia = 'DOM';
				break;
			case 1:
				$dia = 'LUN';
				break;
			case 2:
				$dia = 'MAR';
				break;
			case 3:
				$dia = 'MIE';
				break;
			case 4:
				$dia = 'JUE';
				break;
			case 5:
				$dia = 'VIE';
				break;
			case 6:
				$dia = 'SAB';
				break;
			default:
				break;
		}
		return $dia;
	}
	
	function diferencia_fechas($fecha1, $fecha2)
	{
		$fecha1 = str_replace("-","",$fecha1);
		$fecha1 = str_replace("/","",$fecha1);
		$fecha2 = str_replace("-","",$fecha2);
		$fecha2 = str_replace("/","",$fecha2);
		
		preg_match( "/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fecha1, $aFecIni);
		preg_match( "/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fecha2, $aFecFin);
		
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
		
		return round(($date2 - $date1) / (60 * 60 * 24));
	}
	
	function sumar_fecha($anio, $mes, $dia, $dias){
		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
		  $dias_adelanto = $dias;
		  $siguiente = $dia + $dias_adelanto;
		  if ($ultimo_dia < $siguiente)
		  {
		     $dia_final = $siguiente - $ultimo_dia;
		     $mes++;
		     if ($mes == '13')
		 {
		    $anio++;
		    $mes = '01';
		 }
		 $fecha_final = $anio.'-'.agregar_cero_fecha($mes).'-'.agregar_cero_fecha($dia_final);         
		  }
		  else
		  {
		     $fecha_final = $anio .'-'.agregar_cero_fecha($mes).'-'.agregar_cero_fecha($siguiente);         
		  }
		  return $fecha_final;
	}
	
	function sumar_mes($anio, $mes, $dia, $suma) {
		$fecha_cambiada = mktime(0, 0, 0, $mes+$suma, $dia, $anio);
		$fecha = date("d/m/Y", $fecha_cambiada);
		return $fecha;  
	}
	
	function agregar_cero_fecha($numero) {
		$numero = (int)$numero;
		if($numero < 10) {
			return '0'.$numero;
		} else {
			return $numero;
		}
	}
        
	function edad($fecha)
	{
		list($anio,$mes,$dia) = explode("-",$fecha);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($mes_dif < 0) {
			$anio_dif--;
		} else if($mes_dif == 0 && $dia_dif < 0 ) {
			$anio_dif--;
		}
		return $anio_dif;
	}
	
	function formato_fecha_ddmmaaaa($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . "/" . $array[1] . "/" . $array[0];
		else
			return '';
	}
	
	function formato_fecha_texto($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . " de " . nombre_mes($array[1]) . " de " . $array[0];
		else
			return '';
	}
	
	function formato_fecha_texto_abr($fecha)
	{
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2] . "/" . nombre_mes_abr($array[1]) . "/" . $array[0];
		else
			return '';
	}
	
	function formato_hora_hh($hora) {
		if($hora < 10) {
			$hora = '0'.$hora;
		}
		return $hora;
	}
	
	function traer_mes($fecha) {
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[1];
		else
			return '';
	}
	
	function traer_anio($fecha) {
		if(strpos($fecha, '-') === FALSE)
			$array = explode('/', $fecha);
		else
			$array = explode('-', $fecha);
		if(count($array) == 3)
			return $array[2];
		else
			return '';
	}
	
	function separar_fecha_hora($fecha_hora)
	{
		$array = explode(" ", $fecha_hora);
		return $array;
	}
	
	function nombre_mes($mes)
	{
		if($mes==1) {
			return "enero";
		} else if($mes==2) {
			return "febrero";
		} else if($mes==3) {
			return "marzo";
		} else if($mes==4) {
			return "abril";
		} else if($mes==5) {
			return "mayo";
		} else if($mes==6) {
			return "junio";
		} else if($mes==7) {
			return "julio";
		} else if($mes==8) {
			return "agosto";
		} else if($mes==9) {
			return "septiembre";
		} else if($mes==10) {
			return "octubre";
		} else if($mes==11) {
			return "noviembre";
		} else if($mes==12) {
			return "diciembre";
		} else {
			return "";
		}
	}
	
	function nombre_mes_abr($mes)
	{
		if($mes==1) {
			return "ENE";
		} else if($mes==2) {
			return "FEB";
		} else if($mes==3) {
			return "MAR";
		} else if($mes==4) {
			return "ABR";
		} else if($mes==5) {
			return "MAY";
		} else if($mes==6) {
			return "JUN";
		} else if($mes==7) {
			return "JUL";
		} else if($mes==8) {
			return "AGO";
		} else if($mes==9) {
			return "SEP";
		} else if($mes==10) {
			return "OCT";
		} else if($mes==11) {
			return "NOV";
		} else if($mes==12) {
			return "DIC";
		} else {
			return "";
		}
	}
	
	function extension_archivo($str) {
		return strtolower(end(explode(".", $str)));
	}
	function genera_slug($str){

		$slug			= strtolower($str);

		$restriccion	=	array('&nbsp;','á','é','í','ó','ú','ñ',' ',';',':','¿','?','%','$','!', '&','/','(',')','*','#',',','"','¡',"'",'=','.');
		$cambio			=	array('-','a','e','i','o','u','n',"_","","","","","","","","","","","","","","","","","","","");

		$slug 			=	str_replace($restriccion,$cambio,$slug);
		
		return $slug;

	}

	function generar_folio($clave, $numero) {
	
	if($numero < 10) {
		return $clave.'-00000'.$numero;
	} else if($numero < 100) {
		return $clave.'-0000'.$numero;
	} else if($numero < 1000) {
		return $clave.'-000'.$numero;
	} else if($numero < 10000) {
		return $clave.'-00'.$numero;
	} else if($numero < 100000) {
		return $clave.'-0'.$numero;
	} else {
		return $clave.'-'.$numero;
	}
	}

function hace_tiempo($valor){

// FORMATOS:
// segundos    desde 1970 (función time())        hace_tiempo('12313214');
// defecto (variable $formato_defecto)        hace_tiempo('12:01:02 04-12-1999');
// tu propio formato                        hace_tiempo('04-12-1999 12:01:02 [n.j.Y H:i:s]');

$formato_defecto="H:i:s j-n-Y";

// j,d = día
// n,m = mes
// Y = año
// G,H = hora
// i = minutos
// s = segundos

if(stristr($valor,'-') || stristr($valor,':') || stristr($valor,'.') || stristr($valor,',')){

   if(stristr($valor,'[')){
       $explotar_valor=explode('[',$valor);
       $valor=trim($explotar_valor[0]);
       $formato=str_replace(']','',$explotar_valor[1]);
   }else{
       $formato=$formato_defecto;
   }

   $valor = str_replace("-"," ",$valor);
   $valor = str_replace(":"," ",$valor);
   $valor = str_replace("."," ",$valor);
   $valor = str_replace(","," ",$valor);

   $numero = explode(" ",$valor);

   $formato = str_replace("-"," ",$formato);
   $formato = str_replace(":"," ",$formato);
   $formato = str_replace("."," ",$formato);
   $formato = str_replace(","," ",$formato);

   $formato = str_replace("d","j",$formato);
   $formato = str_replace("m","n",$formato);
   $formato = str_replace("G","H",$formato);

   $letra = explode(" ",$formato);

   $relacion[$letra[0]]=$numero[0];
   $relacion[$letra[1]]=$numero[1];
   $relacion[$letra[2]]=$numero[2];
   $relacion[$letra[3]]=$numero[3];
   $relacion[$letra[4]]=$numero[4];
   $relacion[$letra[5]]=$numero[5];

   $valor = mktime($relacion['H'],$relacion['i'],$relacion['s'],$relacion['n'],$relacion['j'],$relacion['Y']);

}

$ht = time()-$valor;
if($ht>=2116800){
$dia = date('d',$valor);
$mes = date('n',$valor);
$año = date('Y',$valor);
$hora = date('H',$valor);
$minuto = date('i',$valor);
$mesarray = array('','ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic');
$fecha = "el $dia de $mesarray[$mes] del $año";
}
$s='';
if($ht<30242054.045){$hc=round($ht/2629743.83);if($hc>1){$s="es";}$fecha="hace $hc mes".$s;}
if($ht<2116800){$hc=round($ht/604800);if($hc>1){$s="s";}$fecha="hace $hc semana".$s;}
if($ht<561600){$hc=round($ht/86400);if($hc==1){$fecha="ayer";}if($hc==2){$fecha="antes de ayer";}if($hc>2)$fecha="hace $hc días";}
if($ht<84600){$hc=round($ht/3600);if($hc>1){$s="s";}$fecha="hace $hc hora".$s;if($ht>4200 && $ht<5400){$fecha="hace más de una hora";}}
if($ht<3570){$hc=round($ht/60);if($hc>1){$s="s";}$fecha="hace $hc minuto".$s;}
if($ht<60){$fecha="hace $ht segundos";}
if($ht<=3){$fecha="ahora";}
return $fecha;

}


function convierte_moneda($numero)
{	

	//$money = number_format($numero, 2, '.', '');
	$money = number_format($numero,2);
	return $money;
}

/* Fin del archivo: utilerias_helper.php */
/* Ubicación: ./application/helpers/utilerias_helper.php */