<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    var $usuario_recuperar;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->form_validation->set_rules('username','nombre de usuario', 'required');
        $this->form_validation->set_rules('password', 'contraseña', 'required|callback_valida_usuario');

        $this->form_validation->set_message('required', 'El campo %s es requerido');
        if($this->form_validation->run()):
            $filtro = array('username' => $this->input->post('username')  , 'password' => sha1($this->input->post('password')));

            $user= $this->login_model->datos_usuario($filtro);

            $array= array(  'ID_USER'       =>  $user->id_user,
                            'USERNAME'      =>  $user->username,
                            'ID_PERFIL'     =>  $user->id_perfil,
                            'PASSWORD'      =>  sha1($this->input->post('password')));

            $this->session->set_userdata($array);

            $this->login_model->actualiza_acceso($user->id_user);

            $array  = array('id_user'   =>  $user->id_user ,
                            'accion'    =>  'Inicio sesión el usuario '.$user->username,
                            'lugar'     =>  'Login',
                            'usuario'   =>  $user->username);

            $this->bitacora_model->insert_log($array);

            switch ($user->id_perfil) {
                case '1':
                    if ($user->consult_mov_int == 1):
                        $this->session->set_userdata('consulta', 'active');
                    else:
                        $this->session->set_userdata('consulta', 'inactive');
                    endif;

                        $this->session->set_userdata(array('base_perfil' => 'admin/dashboard'));
                        redirect(base_url('admin/dashboard'));
                    break;
                
                default:
                    # code...
                    break;
            }

        else:
          $this->load->view('login');   
        endif;
    }

    public function  logout()
    {   
        $array  = array('id_user'   =>  $this->session->userdata('ID_USER')  ,
                        'accion'    =>  'Cerró sesión el usuario '.$this->session->userdata('USERNAME') ,
                        'lugar'     =>  'Login',
                        'usuario'   =>  $this->session->userdata('USERNAME') );

        $this->bitacora_model->insert_log($array);
        
        $this->session->sess_destroy();
        redirect( 'login' );

    }

############################ CALLBACK ######################################

    function valida_usuario ($password){

        $username = $this->input->post('username');
        $filtro = array('username' => $username  , 'password' => sha1($password));

        $datos = $this->login_model->datos_usuario($filtro);
        if(count($datos)!=0)
        {
            if ($datos->username == $username and sha1($password) == $datos->password)
            {
                 return TRUE; 
            }else
            {
                 $this->form_validation->set_message('valida_usuario', 'Usuario o contraseña incorrecta.');
                return FALSE;
            }
        }
        else
        {   
            $this->form_validation->set_message('valida_usuario', 'Usuario o contraseña incorrecta.');
            return FALSE;
        }

    }

}