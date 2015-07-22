<?php
class AccessAction extends Action{

	public function login()
	{		
		if (session('uid'))
		{
			$this->redirect('Index/index');
		}else{
			if(IS_POST)
			{
				$username = $_REQUEST['username'];
				$password = $_REQUEST['password'];
				$Admin 	  = D('Admin');
	
				if(trim($username) == '')
				{
					$this->error('请输入用户名');
				}
				if(trim($password) == '')
				{
					$this->error('请输入密码');
				}
				
				$userInfo = $Admin->where(" username = '{$username}' AND uid = 1 ")->find();

				if ($userInfo['password'] != md5(md5($password)))
				{
					$this->error('用户名或密码不匹配');
				}
				
				session('uid',$userInfo['uid']);
				
				$this->success('登录成功');
			}else{
				$this->display();
			}
		}
	}
			
	public function logout()
	{
		if (session('uid'))
		{
			session('uid',NULL);
			session_destroy();
			$this->redirect('Index/index');
		}
	}
}