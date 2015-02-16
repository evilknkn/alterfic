<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mov_delete extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }
    
	public function pago($id_empresa, $id_banco, $id_pago)
	{
		$this->load->model('cuentas/delete_movimiento_model', 'mov_model');
		$this->load->model('cuentas/depositos_model');
		
		$dt_pago = $this->depositos_model->pago_info(array('id_pago'=>$id_pago));

		$pagoInfo = $this->depositos_model->detalle_pago($id_pago);

		$this->mov_model->delete_registro('ad_deposito_pago', array('id_pago' =>$id_pago)); 
		$this->mov_model->delete_registro('ad_salidas', array('id_salida' =>$dt_pago->id_movimiento)); 
		$this->mov_model->delete_registro('ad_detalle_cuenta', array('id_detalle' =>$dt_pago->id_detalle)); 

		$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                        'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' eliminó un pago con monto de'.$pagoInfo->monto_pago.' del depósito con folio '. $pagoInfo->folio_depto.' de la empresa '. $pagoInfo->nombre_empresa.' del banco '.$pagoInfo->nombre_banco.'.' ,
                        'lugar'     =>  'Pago eliminado',
                        'usuario'   =>  $this->session->userdata('USERNAME'));

        $this->bitacora_model->insert_log($array);
		
		$this->session->set_flashdata('success', 'Pago eliminado correctamente');
		redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco));
	}

	public function movimiento_interno($id_empresa, $id_banco, $id_movimiento)
	{
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('cuentas/delete_movimiento_model', 'mov_model');

		$detalle = $this->movimientos_model->detalle_movimiento($id_movimiento);

		// Salida de movimiento interno
		$salida_int = $this->movimientos_model->detalle_salida($detalle->folio_salida);
		// Deposito internos
		$depo_int = $this->movimientos_model->detalle_deposito($detalle->folio_entrada);

		# Se borra el movimiento interno 
		$this->mov_model->delete_registro('ad_movimientos_internos', array('id_movimiento' =>$id_movimiento)); 
		# Se borra registro en la tabla de salida y su registro en el detalle de movimiento
		$this->mov_model->delete_registro('ad_salidas', array('id_salida' =>$salida_int->id_salida)); 
		$this->mov_model->delete_registro('ad_detalle_cuenta', array('id_detalle' =>$salida_int->id_detalle));
		#Se borra registro de depósito y su registro en el detalle de movimiento
		$this->mov_model->delete_registro('ad_depositos', array('id_deposito' =>$depo_int->id_deposito)); 
		$this->mov_model->delete_registro('ad_detalle_cuenta', array('id_detalle' =>$depo_int->id_detalle));


		$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                        'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' eliminó el movimiento interno con id '.$id_movimiento,
                        'lugar'     =>  'Pago eliminado',
                        'usuario'   =>  $this->session->userdata('USERNAME'));

        $this->bitacora_model->insert_log($array);
		
		$this->session->set_flashdata('success', 'Movimiento interno eliminado correctamente');
		redirect(base_url('cuentas/movimientos_internos/lista/'.$id_empresa.'/'.$id_banco));

	}

}