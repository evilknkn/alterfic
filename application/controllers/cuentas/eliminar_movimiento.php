<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Eliminar_movimiento extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }

    public function trash_deposito($id_empresa, $id_banco, $id_movimiento, $id_deposito)
    {
    	$this->load->model('cuentas/trash_model', 'trash_model');

    	## Eliminar movimiento en la tabla ad_depositos
	   	$this->trash_model->eliminar_movimiento('ad_depositos', array('id_deposito' => $id_deposito));

	   	##Eliminar movimiento en la tabla general de movimientos ad_detalle_cuenta 
	   	$this->trash_model->eliminar_movimiento('ad_detalle_cuenta', array('id_detalle' => $id_movimiento));


	   	##Bitacora

	   	$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                        'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). '  '.$this->input->post('monto_depto').' a la empresa '. $empresa->nombre_empresa.' en banco '. $empresa->nombre_banco.' con folio '.trim($this->input->post('folio_depto')).'.' ,
                        'lugar'     =>  'Deposito',
                        'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

	   	redirect(base_url().'/cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco);
    }
}
