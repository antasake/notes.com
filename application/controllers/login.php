<?php 

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('membership_model');
	}
	
	function index()
	{
		
		$this->load->view('include/header');
		$this->load->view('login_form');
		$this->load->view('include/footer');
	}
	
	function validate_credentials()
	{
		$this->load->model('membership_model');
		$query=$this->membership_model->validate();
		
		if($query)
		{
			$data = array(
				'username' => $this ->input->post('username'),
				'is_logged_in'=> true
				);
			$this->session->set_userdata($data);
			redirect('member_area');
		}
		else
		{
			$this->index();
		}
	}
	
	function signup()
	{
		$this->load->view('include/header');
		$this->load->view('signup_form');
		$this->load->view('include/footer');
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name','Name','trim|required');
		$this->form_validation->set_rules('last_name','Last Name','trim|required');
		$this->form_validation->set_rules('email','Email Address','trim|required|valid_email|callback_check_if_email_exists');
		$this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[15]|callback_check_if_username_exists');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password_confirm','Password Confirmation','trim|required|matches[password]');
		
		if ($this->form_validation->run()==FALSE)
		{
			$this->load->view('include/header');
			$this->load->view('signup_form');
			$this->load->view('include/footer');
		}
		else
		{
			$this->load->model('membership_model');
			
			if($query =$this->membership_model->create_member())
			{
				$data['account_created']= 'Your account has been created.<br/><br/>You may now login.';
				
				$this->load->view('include/header');
				$this->load->view('login_form',$data);
				$this->load->view('include/footer');
			}
			else
			{
				$this->load->view('include/header');
				$this->load->view('signup_form');
				$this->load->view('include/footer');
			}
		}
	}
	
	function check_if_username_exists($requested_username)
	{
		$this->load->model('membership_model');
		
		$username_available = $this->membership_model->check_if_username_exists($requested_username);
		
		if($username_available)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function check_if_email_exists($requested_email)
	{
		$this->load->model('membership_model');
		
		$email_not_in_use = $this->membership_model->check_if_email_exists($requested_email);
		
		if($email_not_in_use)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
		
	function reset_password()
	{
		if(isset($_POST['email']) || (!empty($_POST['email'])))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email','Email Address','trim|required|min_length[6]|max_length[50],valid_email|xss_clean');
			
			if ($this->form_validation->run()==FALSE)
			{
				$this->load->view('view_reset_password',array('error'=>'Please supply a valid email address.'));
			}
			else
			{
				$email = trim($this->input->post('email'));
				$this->load->model('membership_model');
				$result = $this->membership_model->email_exists($email);
				
				if($result)
				{
					$this->send_reset_password_email($email,$result);
					$this->load->view('include/header');
					$this->load->view('view_reset_password_sent',array('email'=>$email));
					$this->load->view('include/footer');
				}
				else
				{
					$this->load->view('include/header');
					$this->load->view('view_reset_password',array('error'=>'Email address not registered with Friends&Notes'));
					$this->load->view('include/footer');
				}
			}
		}
		else
		{
			$this->load->view('include/header');
			$this->load->view('view_reset_password');
			$this->load->view('include/footer');
		}
	}
	
	function reset_password_form($email,$email_code)
	{
		if(isset($email,$email_code))
		{
			$email=trim($email);
			$email_hash=sha1($email.$email_code);
			$this->load->model('membership_model');
			$verified=$this->membership_model->verify_reset_password_code($email,$email_code);
			
			if($verified)
			{
				$this->load->view('include/header');
				$this->load->view('view_update_password',array('email_hash'=>$email_hash,'email_code'=>$email_code,'email'=>$email));
				$this->load->view('include/footer');
			}
			else
			{
				$this->load->view('include/header');
				$this->load->view('view_reset_password',array('error'=> 'There was a problem with your link. Please click it again or request
									to reset your password again','email'=>$email));
				$this->load->view('include/footer');
			}
		}
	}
	
	function update_password()
	{
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email_hash','Email Hash','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[50]|matches[password_conf]|xss_clean');
		$this->form_validation->set_rules('password_conf','Confirmed Password','trim|required|min_length[6]|max_length[50]|xss_clean');
	
		if($this->form_validation->run() ==FALSE)
		{
			$this->load->view('include/header');
			$this->load->view('view_update_password');
			$this->load->view('include/footer');
		}
		else
		{
			$this->load->model('membership_model');
			$result=$this->membership_model->update_password();
			
			if($result)
			{
				$this->load->view('include/header');
				$this->load->view('view_update_password_success');
				$this->load->view('include/menu');
				$this->load->view('include/footer');
			}
			else
			{
				$this->load->view('include/header');
				$this->load->view('view_update_password',array('error' => 'Problem updating your password.'));
				$this->load->view('include/menu');
				$this->load->view('include/footer');
			}
		}
	}
	
	function send_reset_password_email($email,$first_name)
	{
		$this->load->library('email');
		$email_code = md5($this->config->item('salt').$first_name);
		
		$this->email->from('demiantests@gmail.com', 'Friends&Notes');
		$this->email->to($email);
		$this->email->subject('Please reset your password at Friends&Notes');
		
		$message ='<html></head><body>';
		$message .='<p>Dear ' . $first_name . ',</p> ';
		$message .='You have requested to reset your password. Please <strong><a href="' . base_url() .'login/reset_password_form/' . $email . '/'. 
				 $email_code . '">click here</a></strong> to reset your password.</p>';
		$message .='<p>Thank you!</p>';
		$message .='<p>Friends&Notes</p>';
		$message .='</body></html>';
		
		$this->email->message($message);
		$this->email->send();
	}
	
}
?>