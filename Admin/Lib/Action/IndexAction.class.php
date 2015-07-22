<?php
class IndexAction extends CommonAction{
    
	public function index()
	{
		$this->assign('title', '欢迎');
		$this->display();
    }
	
	public function updatePassword()
	{
		if(IS_POST)
		{
			$oldpass 		=	$_REQUEST['oldpass'];
			$newpass 		=	$_REQUEST['newpass'];
			$confirmpass	=	$_REQUEST['confirmpass'];
			$Admin 	  		= 	D('Admin');

			if($oldpass == '' || $newpass == '' || $confirmpass == '')
			{
				$this->error('请完整填写信息');
			}
			if($oldpass == $newpass)
			{
				$this->error('新旧密码不能相同');
			}
			
			$map			 =	array();
			$map['password'] =	md5(md5($oldpass));
			$map['uid']		 =	session('uid');
			
			if(!$Admin->where($map)->getField('uid'))
			{
				$this->error('旧密码错误！');
			}else {
				$Admin->password = md5(md5($newpass));
				$Admin->uid = session('uid');
				$Admin->save();
				$this->success('密码修改成功！');
			}
		}else{
			$this->assign('title', '修改密码');
			$this->display();
		}
	}
	
	public function ueditorUpload()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();									// 实例化上传类
		$upload->maxSize 			=	2 * 1024 * 1024;			//设置上传图片的大小
		$upload->allowExts 			=	array('jpg','png','gif');	//设置上传图片的后缀
		$upload->autoSub 			=	true;						//是否使用子目录保存上传文件  
		$upload->subType 			=	'date';						//子目录创建方式，默认为hash，可以设置为hash或者date 
		$upload->dateFormat 		=	'Ym';                    	//子目录方式为date的时候指定日期格式  			
		$upload->savePath 			=	C('UPLOAD_PATH');			// 设置附件上传目录
		
		if($upload->upload()){
			$uploadInfo =  $upload->getUploadFileInfo();
			$res = array(
				'state'		=>	'SUCCESS',
				'title'		=>	htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
				'url'		=>	$uploadInfo[0]['savename'],
				'original'	=>	$uploadInfo[0]['name'],
				'filetype'	=>	$uploadInfo[0]['extension'],
				'size'		=>	$uploadInfo[0]['size'],
				'savename'	=>	$uploadInfo[0]['savename']
			);
		}else{
			$res = array(
				'state'		=>	$upload->getErrorMsg()
			);
		}
		echo json_encode($res);
		exit;
	}
}