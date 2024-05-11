<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('index');
	}

	public function about()
	{
		$this->load->view('about');
	}

	public function service()
	{
		$this->load->view('service');
	}

	public function contact()
	{
		$this->load->library('form_validation');
		$this->load->library('email');

		if (isset($_POST['submit'])) {
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$subject = $this->input->post('subject');
			$message = $this->input->post('message');

			$this->form_validation->set_rules('name', 'name', 'required|min_length[3]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			$this->form_validation->set_rules('subject', 'subject', 'required');

			if ($this->form_validation->run() == TRUE) {
				// echo $name;
				// echo $email;
				// echo $subject;
				// echo $message;
				$this->email->from('medilab@example.com', 'Medilab');
				$this->email->to($email);

				$this->email->subject($subject);
				$this->email->message("
				<html>
				<head>
				<title>HTML email</title>
				</head>
				<body>
				<table>
				<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Subject</th>
				<th>Message</th>
				</tr>
				<tr>
				<td>'$name'</td>
				<td>'$email'</td>
				<td>'$subject'</td>
				<td>'$message'</td>
				</tr>
				</table>
				</body>
				</html>
				");

				if($this->email->send()){
					echo '<script>alert("We will contact you shortly!");</script>';
				}
			} else {
				echo '<script>alert("Error in sending e-mail!");</script>';
			}
		}
		$this->load->view('contact');
	}

	public function fileupload()
	{

		$this->load->library('form_validation');

		$data['message'] = '';

		if (isset($_POST['submit'])) {
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 10000;
			$config['max_width']            = 10245;
			$config['max_height']           = 7680;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('doc')) {
				$data['message'] = $this->upload->display_errors();
			} else {
				$data['message'] = $this->upload->data();
			}
		}
		$this->load->view('fileupload', $data);
	}

	public function multiplefileupload()
	{

		$this->load->library('form_validation');

		$data['message'] = '';

		if (isset($_POST['submit'])) {

			$len = count($_FILES['doc']['name']);
			for ($i = 0; $i < $len; $i++) {

				$_FILES['docs']['name'] = $_FILES['doc']['name'][$i];
				$_FILES['docs']['type'] = $_FILES['doc']['type'][$i];
				$_FILES['docs']['tmp_name'] = $_FILES['doc']['tmp_name'][$i];
				$_FILES['docs']['error'] = $_FILES['doc']['error'][$i];
				$_FILES['docs']['size'] = $_FILES['doc']['size'][$i];

				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['max_size']             = 10000;
				$config['max_width']            = 10245;
				$config['max_height']           = 7680;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('docs')) {
					$data['message'] = $this->upload->display_errors();
				} else {
					$data['message'] = $this->upload->data();
				}
			}
		}
		$this->load->view('multiplefileupload', $data);
	}
}
