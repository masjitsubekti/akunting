<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {     

  public function __construct()
  {
    parent::__construct();
    // $this->apl = get_apl();
    $this->load->model('M_main');
		$this->load->model('Auth_m');
  }
  
  public function index()
	{
		$this->load->view('auth/login');
  }

  public function login()
  {
      $this->form_validation->set_rules('username', 'username', 'trim|required');
      $this->form_validation->set_rules('password', 'password', 'trim|required');
      if ($this->form_validation->run() == FALSE){
        $response['success'] = false;
        $response['message'] = "Username atau Password tidak boleh kosong !";
      }else{
        $username = strip_tags($this->input->post('username'));
        $password = md5(strip_tags($this->input->post('password')));
        
        $cek_status = $this->Auth_m->check_auth_login($username, $password);
        if($cek_status->num_rows()!=0){
          $users = $cek_status->row_array();
          $status = $users['status'];
          $email = $users['email'];
          //cek status (aktif, terblokir)
          if($status=="3"){
            $response['success'] = false;
            $response['message'] = "Akun Anda diblokir oleh sistem, hubungi pusat bantuan untuk memulihkannya !";
          }elseif($status=="2"){
            $response['success'] = false;
            $response['message'] = "Anda belum memverifikasi Email yang telah kami kirimkan ke $email !";
          }elseif($status=="1"){
            $cek_login = $this->Auth_m->auth_by_id($users['id']);
            if($cek_login->num_rows()!=0){
              //user ditemukan
              $data_login=$cek_login->result();
              $ses_array = array(
                'auth_id_user' => $data_login[0]->id, 
                'auth_nama_user' => $data_login[0]->nama,
                'auth_username' => $data_login[0]->username,
                'auth_email' => $data_login[0]->email,
                'auth_id_role' => $data_login[0]->id_role, 
                'auth_nama_role' => $data_login[0]->nama_role,
                'auth_foto' => $data_login[0]->foto,
                'auth_is_login' => TRUE,
              );
              $this->session->set_userdata( $ses_array );
          
              $response['success'] = true;
              $response['message'] = "Selamat Datang ".$data_login[0]->nama." !";
              $response['page'] = ($data_login[0]->id_role=='PELANGGAN') ? '/' : '/Dashboard';
            }else{
              //Akun Anda user salah
              $response['success'] = false;
              $response['message'] = "Akun Anda Tidak Ditemukan !";
            }
          }else{
            $response['success'] = false;
            $response['message'] = "Akun Anda dinonaktifkan !";
          }
        }else{
          //Akun Anda user salah
          $response['success'] = false;
          $response['message'] = "Username atau password salah !";
        }
      }
      echo json_response($response);
  }

  function logout(){
		$this->session->sess_destroy();
		$data['success'] = TRUE;
		$data['message'] = "Anda Berhasil Logout !";
		$data['page'] = "Auth";
		echo json_response($data);
	}
}