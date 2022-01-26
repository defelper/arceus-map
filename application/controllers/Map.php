<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {

	public function index()
	{
		echo 'Douglas';
	}

	public function getdata()
	{
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('resposta' => 'Douglas')));
		$this->output->set_status_header(200);
	}

	public function loadmap($id) {
		switch ($id) {
			case 1:
				$this->load->view('map1');
				break;

			default:
				$this->load->view('errors/html/error_404');
		}
	}

	public function getpins() {
		$mapId = $this->input->post('map');

		$data = $this->load->view('data/map1.json', '', true); //this will load countries.json

		$this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output($data);
	}
}
