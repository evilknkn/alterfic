<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Generate_key extends  CI_Controller
{	
	public function factory()
	{
		$this->load->model('tool/eloquent_model');

		$db = $this->eloquent_model;

		$data_where = array('estatus' => 1, 'tipo_usuario' => 1);
		$factories =  $db->get_query('ad_catalogo_empresa', $data_where);

		foreach($factories as $factory )
		{	
			$clave = strtoupper(substr($factory->nombre_empresa, 0, 3));
			echo '/////////////////////////////////////////////////////////////////////// <br>';
			echo $factory->nombre_empresa.'<br>';
			echo "clave:".$clave.'<br>' ;

			$data_up = array('clave_cta' => $clave);
			//$db->update_where_query('ad_catalogo_empresa', $data_up, array('id_empresa' => $factory->id_empresa));
		}
		

	}

	public function key_bancos_empresa()
	{
		$this->load->model('tool/eloquent_model');

		$db = $this->eloquent_model;

		$lista = $db->lista_empresas();

		foreach($lista as $key)
		{	
			$clave = $key->clave_cta.$key->clave_banco;
			echo '/////////////////////////////////////////////////////////////////////// <br>';
			echo $key->nombre_empresa.'<br>';
			echo "nombre banco: ".$key->nombre_banco.'/'. $key->clave_banco.'<br>';
			echo "clave:".$key->clave_cta.$key->clave_banco.'<br>' ;

			$data_up = array('clave' => $clave);
			$data_where = array('id_empresa' => $key->id_empresa, 'id_banco' => $key->id_banco);
			$db->update_where_query('ad_bancos_empresa', $data_up, $data_where);
		}	
	}


}