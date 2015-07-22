<?php
class CommonAction extends Action{
	
	public function _initialize()
	{
		if(!session('uid'))
		{
			$this->redirect('Access/login');
		}else{
			$Admin = D('Admin');
			$uid = session('uid');		
			$adminName = $Admin->where(" uid = {$uid} ")->getField('username');
			$menu = C('MENU');
			
			foreach ($menu as $key => $value)
			{
				foreach ($value['child'] as $k => $v)
				{
					$url = U($value['module'].'/'.$v['action'],$v['search']);

					if($url == __SELF__)
					{
						$nav 	= $v['name'];
						$navUrl = $url;
						$menu[$key]['child'][$k]['cur'] = 1;
					}elseif(MODULE_NAME == $value['module'] &&  strstr(ACTION_NAME,$v['action']) && ACTION_NAME != $v['action']){
						
						$nav 	= $v['name'];
						$navUrl = $url;
						$menu[$key]['child'][$k]['cur'] = 1;
					}

					$menu[$key]['child'][$k]['url'] = $url;
				}
			}

			$this->assign('adminName', $adminName);
			$this->assign('doMain', C('DOMAIN'));
			$this->assign('moudleName', MODULE_NAME);
			$this->assign('menu', $menu);
			$this->assign('nav', $nav);
			$this->assign('navUrl', $navUrl);
		}
	}
	
	public function uploadFile()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();									//实例化上传类
		$upload->maxSize 			=	1 * 1024 * 1024;			//设置上传图片的大小
		$upload->allowExts 			=	array('doc');				//设置上传图片的后缀
		$upload->autoSub 			=	true;						//是否使用子目录保存上传文件  
		$upload->subType 			=	'date';						//子目录创建方式，默认为hash，可以设置为hash或者date 
		$upload->dateFormat 		=	'Ym';                    	//子目录方式为date的时候指定日期格式  			
		$upload->savePath 			=	C('UPLOAD_PATH');			//设置附件上传目录
		
		if(!$upload->upload())
		{
			$this->error($upload->getErrorMsg());
		}else{
			$uploadInfo = $upload->getUploadFileInfo();
			return $uploadInfo[0]['savename'];
		}
	}
}
?>