<?php
class ResumeAction extends CommonAction{
	
	public function search()
	{
		if(IS_POST)
		{
			$keyword = trim($_REQUEST['keyword']);
			$id_51job = trim($_REQUEST['id_51job']);
			$name = trim($_REQUEST['name']);
			$mobile = trim($_REQUEST['mobile']);
			$userList = array();
			
			if(empty($keyword))
			{
				if(!empty($id_51job) || !empty($name) || !empty($mobile))
				{
					$where = ' 1=1 ';
					
					if(!empty($id_51job))
					{
						$where .= " AND id_51job = '{$id_51job}' ";
						$this->assign('id_51job', $id_51job);
					}
					if(!empty($name))
					{
						$where .= " AND name = '{$name}' ";
						$this->assign('name', $name);
					}
					if(!empty($mobile))
					{
						$where .= " AND mobile = '{$mobile}' ";
						$this->assign('mobile', $mobile);
					}
					$userModel = D('User');
					$dictMajorModel = D('DictMajor');
					$dictLocationModel = D('DictLocation');
	
					$userList = $userModel->where($where)->select();
	
					foreach($userList as $key => $value)
					{
						$userList[$key]['sex']		=	getSex($value['sex']);
						$userList[$key]['birthday']	=	getBirthday($value['birthday']);
						$userList[$key]['age']		=	getAge($value['birthday']);
						$userList[$key]['workyear']	=	getDictValue('WORKYEAR', $value['workyear']);
						$userList[$key]['location']	=	$dictLocationModel->getLocationName($value['location']);
						$userList[$key]['jobstatus']=	getDictValue('JOBSTATUS', $value['jobstatus']);
						$userList[$key]['degrees']	=	getDictValue('DEGREES', $value['degrees']);
						$userList[$key]['major']	=	$dictMajorModel->getMajorName($value['major']);
					}
				}
				
			}else{
				
				
			}
		}
		$this->assign('userList', $userList);
		$this->assign('workyear', C('WORKYEAR'));
		$this->assign('domain', C('domain'));
		$this->assign('title', '列表');
		$this->display();
    }
	
	public function view()
	{
		$uid = intval($_REQUEST['uid']);

		if(!$uid)
		{
			$this->error('错误用户');
		}
				
		$userModel = D('User');
		$intentionModel = D('Intention');
		$introModel = D('Intro');
		$userJoinKeywordModel = D('UserJoinKeyword');
		$userJoinFunctionModel = D('UserJoinFunction');
		$jobModel = D('Job');
		$projectModel = D('Project');
		
		$dictMajorModel = D('DictMajor');
		$dictLocationModel = D('DictLocation');
		
		$data = array();
		$data['user'] = $userModel->where(" uid = {$uid} ")->find();
		$data['intention'] = $intentionModel->where(" uid = {$uid} ")->find();
		$data['intro'] = $introModel->where(" uid = {$uid} ")->getfield('intro');
		$data['keyword'] = $userJoinKeywordModel->field('keyword.keyword')->join('LEFT JOIN keyword ON user_join_keyword.keyword_id = keyword.id ')->where(" uid = {$uid} ")->select();	
		$data['function'] = $userJoinFunctionModel->field('dict_function.function_name')->join('LEFT JOIN dict_function ON user_join_function.function_id = dict_function.function_id ')->where(" uid = {$uid} ")->select();	
		$data['job'] = $jobModel->where(" uid = {$uid} ")->select();
		$data['project'] = $projectModel->where(" uid = {$uid} ")->select();

		$data['user']['sex']		=	getSex($data['user']['sex']);
		$data['user']['age']		=	getAge($data['user']['birthday']);
		$data['user']['birthday']	=	getBirthday($data['user']['birthday']);
		$data['user']['workyear']	=	getDictValue('WORKYEAR', $data['user']['workyear']);
		$data['user']['location']	=	$dictLocationModel->getLocationName($data['user']['location']);
		$data['user']['jobstatus']	=	getDictValue('JOBSTATUS', $data['user']['jobstatus']);
		$data['user']['degrees']	=	getDictValue('DEGREES', $data['user']['degrees']);
		$data['user']['major']		=	$dictMajorModel->getMajorName($data['user']['major']);

		$data['intention']['jobarea']		=	$dictLocationModel->getLocationName($data['intention']['jobarea']);
		$data['intention']['salary']		=	getDictValue('SALARY', $data['intention']['salary']);

		$this->assign('data', $data);
		$this->assign('title', '查看');
		$this->display();
	}
	
	public function del()
	{
		$uid = intval($_REQUEST['uid']);

		if(!$uid)
		{
			$this->error('删除失败');
		}		
		
		$userModel = D('User');
		$intentionModel = D('Intention');
		$introModel = D('Intro');
		$userJoinKeywordModel = D('UserJoinKeyword');
		$userJoinFunctionModel = D('UserJoinFunction');
		$jobModel = D('Job');
		$projectModel = D('Project');
				
		$resumepath = $userModel->where(" uid = {$uid} ")->getField('resumepath');
		//开始删除
		@unlink($resumepath);
		$userModel->where(" uid = {$uid} ")->delete();
		$intentionModel->where(" uid = {$uid} ")->delete();
		$introModel->where(" uid = {$uid} ")->delete();
		$userJoinKeywordModel->where(" uid = {$uid} ")->delete();
		$userJoinFunctionModel->where(" uid = {$uid} ")->delete();
		$jobModel->where(" uid = {$uid} ")->delete();
		$projectModel->where(" uid = {$uid} ")->delete();

		$this->redirect('search');
	}
	
	public function handle()
	{
		if(IS_POST)
		{
			
			$resumePath = C('UPLOAD_PATH').$this->uploadFile();
			$resumeMd5 = md5_file($resumePath);
			$resumeData = $this->handleResume($resumePath);

			$userModel = D('User');
			if(!$userModel->hasUserByMd5($resumeMd5))
			{
				@unlink($resumePath);
				$this->error('已上传并处理过该简历');
			}
			//基本信息
			$userData = array();
			$userData['id_51job']	=	$resumeData['userdata']['id_51job'];
			$userData['name']		=	$resumeData['userdata']['name'];
			$userData['sex']		=	$resumeData['userdata']['sex'];
			$userData['workyear']	=	$resumeData['userdata']['workyear'];
			$userData['birthday']	=	$resumeData['userdata']['birthday'];
			$userData['mobile']		=	$resumeData['userdata']['moblie'];
			$userData['email']		=	$resumeData['userdata']['email'];
			$userData['location']	=	$resumeData['userdata']['location'];
			$userData['jobstatus']	=	$resumeData['userdata']['jobstatus'];
			$userData['degrees']	=	$resumeData['userdata']['degrees'];
			$userData['major']		=	$resumeData['userdata']['major'];
			$userData['resumepath']	=	$resumePath;
			$userData['resumemd5']	=	$resumeMd5;
			$userData['ctime']		=	time();
	
			$uid = $userModel->add($userData);
			
			//求职意向
			$intentionData = array();
			$intentionData['uid']		=	$uid;
			$intentionData['jobarea']	=	$resumeData['intentiondata']['jobarea'];
			$intentionData['salary']	=	$resumeData['intentiondata']['salary'];
			
			$intentionModel = D('Intention');
			$intentionModel->add($intentionData);
			
			//个人简介
			$introData = array();
			$introData['uid']		=	$uid;
			$introData['intro']		=	$resumeData['intro'];
			
			$introModel = D('Intro');
			$introModel->add($introData);

			//关键词
			$keywords = explode(' ',$resumeData['keyword']);
			$keywordModel = D('Keyword');
			$userJoinKeywordModel = D('UserJoinKeyword');
			
			foreach($keywords as $value)
			{
				if(!empty($value))
				{
					$keyword_id = $keywordModel->getKeywordId($value);
					$keywordData = array();
					$keywordData['uid'] = $uid; 
					$keywordData['keyword_id'] = $keyword_id; 
					$userJoinKeywordModel->add($keywordData);
				}
			}
			
			//职能
			$functions = explode('，',$resumeData['function']);

			$dictFunctionModel = D('DictFunction');
			$userJoinFunctionModel = D('UserJoinFunction');
			
			foreach($functions as $value)
			{
				if(!empty($value))
				{
					$function_id = $dictFunctionModel->getFunctionId($value);
					$functionData = array();
					$functionData['uid'] = $uid; 
					$functionData['function_id'] = $function_id; 
					$userJoinFunctionModel->add($functionData);
				}
			}
			
			//工作经验
			$jobModel = D('Job');
			foreach($resumeData['jobdata'] as $value)
			{
				$jobData = array();
				$jobData['uid'] 		= $uid; 
				$jobData['starttime'] 	= $value['starttime']; 
				$jobData['endtime'] 	= $value['endtime']; 
				$jobData['company'] 	= $value['company']; 
				$jobData['industry'] 	= $value['industry']; 
				$jobData['division'] 	= $value['division']; 
				$jobData['job'] 		= $value['job']; 
				$jobData['responsibility']= $value['responsibility']; 
				$jobModel->add($jobData);
			}
			
			//项目经验
			$projectModel = D('Project');
			foreach($resumeData['projectdata'] as $value)
			{
				$ProjectData = array();
				$ProjectData['uid'] 		= $uid; 
				$ProjectData['starttime'] 	= $value['starttime']; 
				$ProjectData['endtime'] 	= $value['endtime']; 
				$ProjectData['projectname']	= $value['projectname']; 
				$ProjectData['description']	= $value['description']; 
				$ProjectData['responsibility']= $value['responsibility'];
				$projectModel->add($ProjectData);
			}

			$this->redirect('handle');
		}else{
			$this->assign('title', '处理');
			$this->display();
		}
    }
		
	public function handleResume($resumePath)
	{		
		$data = file_get_contents($resumePath);
		$data = explode('----boundary',$data);
		$data = explode('Content-Transfer-Encoding:base64',$data[1]);
		$data = trim($data[1]);
		$data = base64_decode($data);
		$type = mb_detect_encoding($data, array('UTF-8', 'GBK', 'CP936'));
		$data = mb_convert_encoding($data, "UTF-8", $type);
		$data = preg_replace("/([\r\n|\n|\t]+)/",'',$data);
		
		//匹配51jobid
		preg_match('/\(ID:(\d.*?)\)/',$data, $id_51job);
		$id_51job = $id_51job[1];

		//姓名
		preg_match('/<b>(.*?)<\/b>/',$data, $name);
		$name = $name[1];
		
		//基本信息
		preg_match('/<span class="blue"><b>(.*?)<\/b>/',$data, $userinfo);
		$userinfo = explode('&nbsp;',$userinfo[1]);
		
		preg_match('/（(.*?)）/',$userinfo[2], $age);
		$age = str_replace('年','-',$age[1]);
		$age = str_replace('月','-',$age);
		$age = str_replace('日','',$age);
		
		//性别
		$sex = trim($userinfo[1]);
		
		//出生日期
		$birthday = strtotime($age);
	
		//工作年限
		$workyear = $userinfo[0];
		
		//手机号码
		preg_match('/\d{11}（手机）/',$data, $moblie);
		$moblie = str_replace('（手机）','',$moblie[0]);
		
		//Email
		preg_match('/href="mailto:(.*?)"/',$data, $email);
		$email = $email[1];
	
		//居住地
		preg_match('/<tr><td width="10%" height="20">居住地：<\/td><td width="42%" height="20">(.*?)<\/td>/',$data, $location);
		$location = $location[1];
	
		//求职状态
		preg_match('/<tr><td class="text_left">\s*求职状态：\s*<span class="text" style="padding-left:10px;">(.*?)<\/span><\/td><\/tr>/',$data, $jobstatus);
		$jobstatus = $jobstatus[1];
		
		//学历
		preg_match('/<tr><td width="59">学　历：<\/td><td width="230">(.*?)<\/td><\/tr>/',$data, $degrees);
		$degrees = $degrees[1];
		
		//专业
		preg_match('/<tr><td>专　业：<\/td><td>(.*?)<\/td><\/tr>/',$data, $major);
		$major = $major[1];

		//简历关键词
		preg_match('/<span id="spanTitled">(.*?)<\/span>/',$data, $keyword);
		$keyword = isset($keyword[1])	?	$keyword[1]	: "";
		
		//自我评价
		preg_match('/<span class="text">(.*?)<\/span>/',$data, $intro);
		$intro = $intro[1];
		
		//地点
		preg_match('/<td class="text_left">\s*目标地点：\s*<span class="text" style="padding-left:10px;">(.*?)<\/span><\/td>/',$data, $jobarea);
		$jobarea = explode('，', $jobarea[1]);
		$jobarea = $jobarea[0];
		
		//职能
		preg_match('/<td class="text_left">\s*目标职能：\s*<span class="text" style="padding-left:10px;">(.*?)<\/span><\/td>/',$data, $function);
		$function = $function[1];
	
		//期望薪资
		preg_match('/<td class="text_left">\s*期望月薪：\s*<span class="text" style="padding-left:10px;">(.*?)<\/span><\/td>/',$data, $salary);
		$salary = explode('/', $salary[1]);
		$salary = $salary[0];
	
		//匹配工作经验
		preg_match_all('/<tr><td colspan="2" class="text_left">(\w{4}\s*\/\w{0,2})--([^：]*?)：([^>]*?)<img[^>]*?><span class="graybutton"><b>(.*?)<\/b><\/span><\/td><\/tr><tr><td width="22%" class="text_left">所属行业：<\/td><td width="78%" class="text">(.*?)<\/td><\/tr><tr><td class="text_left"><b>(.*?)<\/b><\/td><td class="text"><b>(.*?)<\/b><\/td><\/tr><tr><td colspan="2" class="text_left">(.*?)<\/td><\/tr>/',$data, $jobData);
	
		$newJobData = array();
		$count = count($jobData[0]);
		for($i = 0; $i < $count; $i++)
		{
			$newJobData[$i]['starttime'] 	=	strtotime(str_replace('      /','-',$jobData[1][$i]));		
			$newJobData[$i]['endtime'] 		=	strtotime(str_replace('      /','-',$jobData[2][$i]));	
			$compangData =	explode('(',$jobData[3][$i]);
			$newJobData[$i]['company'] 		=	$compangData[0];		
			$newJobData[$i]['industry'] 	=	$jobData[5][$i];	
			$newJobData[$i]['division'] 	=	$jobData[6][$i];	
			$newJobData[$i]['job'] 			=	$jobData[7][$i];	
			$newJobData[$i]['responsibility']=	$jobData[8][$i];		
		}
		
		//匹配项目经验
		preg_match_all('/<tr><td colspan="2" class="text_left">(\w{4}\s*\/\w{0,2})--([^：]*?)：([^>]*?)<\/td><\/tr>.*?项目描述：<\/td><td width="84%" class="text">(.*?)<\/td><\/tr><tr><td class="text_left" valign="top">责任描述：<\/td><td class="text">(.*?)<\/td><\/tr>/',$data, $projectData);
		
		$newProjectData = array();
		$count = count($projectData[0]);
		for($i = 0; $i < $count; $i++)
		{
			$newProjectData[$i]['starttime'] 		=	strtotime(str_replace('      /','-',$projectData[1][$i]));		
			$newProjectData[$i]['endtime'] 			=	strtotime(str_replace('      /','-',$projectData[2][$i]));		
			$newProjectData[$i]['projectname']		=	$projectData[3][$i];		
			$newProjectData[$i]['description']		=	$projectData[4][$i];	
			$newProjectData[$i]['responsibility']	=	$projectData[5][$i];	
		}

		$dictMajorModel = D('DictMajor');
		$dictLocationModel = D('DictLocation');

		$insert['userdata']['id_51job'] = 	$id_51job;
		$insert['userdata']['name']		= 	$name;
		$insert['userdata']['sex'] 		=	$sex == '女' ? '0' : 1;
		$insert['userdata']['birthday']	= 	$birthday;
		$insert['userdata']['workyear']	= 	getDictKey('WORKYEAR', $workyear);
		$insert['userdata']['moblie']	= 	$moblie;
		$insert['userdata']['email']	= 	$email;
		$insert['userdata']['location']	= 	$dictLocationModel->getLocationId($location);
		$insert['userdata']['jobstatus']= 	getDictKey('JOBSTATUS',$jobstatus);
		$insert['userdata']['degrees']	= 	getDictKey('DEGREES',$degrees);
		$insert['userdata']['major']	= 	$dictMajorModel->getMajorId($major);
		
		$insert['intentiondata']['jobarea']	= 	$dictLocationModel->getLocationId($jobarea);
		$insert['intentiondata']['salary']	= 	getDictKey('SALARY',$salary);
		
		$insert['intro']	= 	$intro;
		
		$insert['keyword']	= 	$keyword;
		
		$insert['function']	=	$function;
		
		$insert['jobdata']		= 	$newJobData;
		
		$insert['projectdata']	= 	$newProjectData;
		
		return $insert;	
	}
	
}