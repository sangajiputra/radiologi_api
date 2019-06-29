<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/jwt/JWT.php';
require_once APPPATH.'libraries/jwt/ExpiredException.php';
require_once APPPATH.'libraries/jwt/SignatureInvalidException.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class UserController extends CI_Controller {

	private $secret = 'hayo apa passwordnya';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');

		//==== ALLOWING CORS

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, OPTION');
        header("Access-Control-Allow-Headers: *");
	}

	public function response($data, $status=200)
	{
		$this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
	}

	public function register()
	{
		return $this->response($this->user->save());
	}

	public function get_all()
	{
		return $this->response($this->user->get_all());
	}

	public function get($id)
	{
		return $this->response($this->user->get_all('id', $id));
	}	

	public function update($id)
	{
		if ($user_id_from_token = $this->cek_token())
		{
			if ($user_id_from_token == $id)
			{
				$data = array(
					'email'      	=> $this->input->post('email'),
					'password'   	=> md5($this->input->post('password')),
					'update_at'		=> date('Y-m-d H:i:s')
				);
				if($this->user->edit($id, $data)){
					$user = $this->user->get_all('id', $id);
					return $this->response([
						'data'      => $user,
						'success'   => true,
						'message'   => 'data berhasil dimasukkan'
					]);
				}
				else
				{
					return $this->response([
						'success'   => false,
						'message'   => 'ada kesalahan'
					]);
				};
				
			}
			else
			{
				return $this->response([
					'success'	=> false,
					'message'	=> 'user berbeda'
				]);
			}
		};
	}	

	public function login()
	{
		$date	= new DateTime();

		$email 			= $this->input->post('email');
		$password 		= md5($this->input->post('password'));
		$user			= $this->user->get_all('email', $email);
		$passwordasli	= $user->password;

		if($password==$passwordasli){
			//lanjutkan encode datanya
			$payload['id']		= $user->id;
			$payload['iat']		= $date->getTimestamp();
			$payload['exp']		= $date->getTimestamp() + 60*60*2;

			$output['id_token']	=	JWT::encode($payload, $this->secret);
			$this->response($output);
			
		}else{
			return $this->response([
				'success'	=> false,
				'message'	=> 'email atau password anda salah'
			]);
		}

	}	

	public function cek_token()
	{
		$jwt = $this->input->get_request_header('token');
        try {
            $data = JWT::decode($jwt, $this->secret, array('HS256'));
            return $data->id;
        } catch (Exception $e) {
            return $this->response([
				'success'	=> false,
				'message'	=> 'gagal mengakses token'
			]);
        }  
	}

	function delete($id)
	{
		//cek user token
		if ($user_id_from_token = $this->cek_token())
		{
			if ($user_id_from_token == $id)
			{
				return $this->response($this->user->delete($id));
			}
			else
			{
				return $this->response([
					'success'	=> false,
					'message'	=> 'user berbeda'
				]);
			}
		}

	}

}
