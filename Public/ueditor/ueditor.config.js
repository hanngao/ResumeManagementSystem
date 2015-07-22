(function () {
	var URL = Domain + 'Public/ueditor/';
	var FILE = Domain + 'admin.php/Index/';
	
    window.UEDITOR_CONFIG = {

        UEDITOR_HOME_URL : URL

        //图片上传配置区
        ,imageUrl: FILE + "ueditorUpload"             //图片上传提交地址
        ,imagePath: Domain + "Upload/"       //图片修正地址，引用了fixedImagePath,如有特殊需求，可自行配置
        ,compressSide:1                            //等比压缩的基准，确定maxImageSideLength参数的参照对象。0为按照最长边，1为按照宽度，2为按照高度
        ,maxImageSideLength:580                    //上传图片最大允许的边长，超过会自动等比缩放,不缩放就设置一个比较大的值，更多设置在image.html中

		,savePath: [ 'upload1' ]					//保存目录  需删除该功能
        ,toolbars: [["source","undo","redo","link","unlink","insertimage","spechars","fontfamily","fontsize","bold","italic","underline","strikethrough","forecolor","superscript","subscript","justifyleft","justifycenter","justifyright","justifyjustify","directionalityltr","directionalityrtl","indent","removeformat","formatmatch","autotypeset"]]
        
		,initialFrameWidth:'100%'  //初始化编辑器宽度,默认1000
        ,initialFrameHeight:320  //初始化编辑器高度,默认320
    };
})();
