<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/jwt/JWT.php';
require_once APPPATH.'libraries/jwt/ExpiredException.php';
require_once APPPATH.'libraries/jwt/SignatureInvalidException.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class RadiologijobsController extends CI_Controller {

	private $secret = 'hayo apa passwordnya';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RadiologiJobModel');

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

	public function get_all()
	{
		return $this->response($this->RadiologiJobModel->get_all());
	}

	public function get($id)
	{
		return $this->response($this->RadiologiJobModel->get_all('id', $id));
	}	

	public function update($id)
	{
		if ($user_id_from_token = $this->cek_token())
		{
			if ($user_id_from_token == $id)
			{
				$data = array(
					'code_job'      => $this->input->post('code_job'),
                    'code'          => $this->input->post('code'),
                    'name'          => $this->input->post('name'),
                    'name_other'    => $this->input->post('name_other'),
                    'is_del'        => $this->input->post('is_del'),
				);
				if($this->RadiologiJobModel->edit($id, $data)){
					$datarow = $this->RadiologiJobModel->get_all('id', $id);
					return $this->response([
						'data'      => $datarow,
						'success'   => true,
						'message'   => 'data berhasil dimasukkan'
                    ], 201);
				}
				else
				{
					return $this->response([
						'success'   => false,
						'message'   => 'ada kesalahan'
                    ], 500);
				};
				
			}
			else
			{
				return $this->response([
					'success'	=> false,
					'message'	=> 'User berbeda'
                ], 404);
			}
		};
	}	

	// public function cek_token()
	// {
	// 	$jwt = $this->input->get_request_header('token');
    //     try {
    //         $data = JWT::decode($jwt, $this->secret, array('HS256'));
    //         return $data->id;
    //     } catch (Exception $e) {
    //         return $this->response([
	// 			'success'	=> false,
	// 			'message'	=> 'gagal mengakses token'
	// 		], 500);
    //     }  
	// }

	function delete($id)
	{
		//cek RadiologiJobModel token
		if ($user_id_from_token = $this->cek_token())
		{
			if ($user_id_from_token == $id)
			{
				return $this->response($this->RadiologiJobModel->delete($id));
			}
			else
			{
				return $this->response([
					'success'	=> false,
					'message'	=> 'User berbeda'
                ], 404);
			}
		}

	}

}
