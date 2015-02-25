<?php 
Class Membership_model extends CI_Model
{
	function validate()
	{
		$this->db->where ('username', $this->input->post('username'));
		$this->db->where ('password',md5($this->input->post('password')));
		$query = $this->db->get('users');
		
		if($query->num_rows ==1)
		{
			return TRUE;
		}
	}
	
	function create_member()
	{
		$username = $this->input->post('username');
		
		$new_member_insert_data = array(
			'first_name' => $this ->input ->post('first_name'),
			'last_name' => $this ->input ->post('last_name'),
			'email' => $this ->input ->post('email'),
			'username' => $this ->input ->post('username'),
			'password' => md5($this ->input ->post('password'))
			);
			
			$insert = $this->db->insert('users', $new_member_insert_data);
			return $insert;
	}
	
	function check_if_username_exists()
	{
		$username = $this->input->post('username');
		
		$this->db->where('username',$username);
		$result = $this->db->get('users');
		
		if($result->num_rows()>0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function check_if_email_exists()
	{
		$email = $this->input->post('email');
		
		$this->db->where('email',$email);
		$result = $this->db->get('users');
		
		if($result->num_rows()>0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function verify_reset_password_code($email,$code)
	{
		$sql = "SELECT first_name, email FROM users WHERE email='{$email}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
		
		if($result->num_rows()===1)
		{
			return($code==md5($this->config->item('salt').$row->first_name))? true:false;
		}
		else
		{
			return false;
		}
	}
	
	function update_password()
	{
		$email=$this->input->post('email');
		$password = sha1($this->config->item('salt').$this->input->post('password'));
			
		$sql = "UPDATE users SET password= '{$password}' WHERE email='{$email}' LIMIT 1";
		$this->db->query($sql);
		
		if($this->db->affected_rows()===1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function email_exists($email)
	{
		$sql = "SELECT first_name, email FROM users where email='{$email}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
		
		return ($result->num_rows()===1 && $row->email) ? $row-> first_name	 : false;

	}
}
?>