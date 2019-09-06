@extends("layout.main")
@section("content")
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span>
	系统管理
	<span class="c-gray en">&gt;</span>
	基本设置
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
	<form action="" class="form form-horizontal" id="form-admin-web-add">
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
				<span>基本设置</span>				
				<!-- <span>邮件设置</span> -->
                <!-- <span>安全设置</span>
				<span>其他设置</span> -->
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						网站标题：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="website-title" name="title" placeholder="控制在25个字、50个字节以内" value="{{$website->title}}" class="input-text">
					</div>
				</div>
                <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">网站logo：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="fileList" class="uploader-list">
						<img src="/{{$website->logo}}" width="100px">
						<input type="hidden" name="logo" value="{{$website->logo}}">
						</div>
                        <div id="filePicker">选择图片</div>                       
                    </div>
			    </div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						关键词：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="website-Keywords" name="key_words" placeholder="5个左右,8汉字以内,用英文,隔开" value="{{$website->key_words}}" class="input-text">
					</div>
				</div>              
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						网站描述：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="website-description" name="web_desc" placeholder="空制在80个汉字，160个字符以内" value="{{$website->web_desc}}" class="input-text">
					</div>
				</div>				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">备案号：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="website-icp"  name="web_icp" placeholder="京ICP备00000000号" value="{{$website->web_icp}}" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						微信验证token</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="wx_token"  value="{{$website->wx_token}}" class="input-text">
					</div>
				</div>
                <div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						appid:</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="wx_appid"  class="input-text" value="{{$website->wx_appid}}">
					</div>
				</div>
                <div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						appsecret:</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="appsecret"  class="input-text" value="{{$website->appsecret}}">
					</div>
				</div>
				{{csrf_field()}}				
			</div>
            <!-- <div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮件发送模式：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  class="input-text" value="" id="" name="">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">SMTP服务器：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">SMTP 端口：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="25" id="" name="" >
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮箱帐号：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="5" id="emailName" name="emailName" >
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮箱密码：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="password" id="email-password" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">收件邮箱地址：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" id="email-address" value="" class="input-text">
					</div>
				</div>
			</div> -->
			<!-- <div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">允许访问后台的IP列表：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<textarea class="textarea" name="" id=""></textarea>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台登录失败最大次数：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="5" id="" name="" >
					</div>
				</div>
			</div> -->
			
			<div class="tabCon">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
			<button type="submit" class="btn btn-success radius" id="admin-web-save" name="admin-web-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</div>

@endsection
@section("footerjs")
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	$("#tab-system").Huitab({
		index:0
	});
});
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
    var token="{{csrf_token()}}";
	$list = $("#fileList"),
	$btn = $("#btn-star"),
	state = "pending",
	uploader;
	var uploader = WebUploader.create({
		auto: true,
		swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',
	
		// 文件接收服务端。
		server: '{{url("admin/website/img")}}',
	       
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '#filePicker',
                formData: {
                    _token: token
                  },
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});	
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress-box .sr-only');
	
		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
		}
		$li.find(".state").text("上传中");
		$percent.css( 'width', percentage * 100 + '%' );
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file,response ) { 
              	var $li = $(
			'<div id="' + file.id + '" class="item">' +
				'<div class="pic-box"><img  style="width:100px" src="/'+response.data+'"></div>'+
				'<div class="info">' + file.name + '</div>' +
				'<p class="state">等待上传...</p>'+
                                '<input type="hidden" name="logo" value="'+response.data+'" >'+
			'</div>');		
		$list.html( $li );           
		$( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
	});
	
	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file ) {
		$( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
	});
	
	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
                
		$( '#'+file.id ).find('.progress-box').fadeOut();
	});
	uploader.on('all', function (type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function () {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
           
        }
    });
	$("#form-admin-web-add").validate({
		rules:{
			title:{
				required:true,
			},
			key_words:{
				required:true,
			},
			web_icp:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",	
	});
    $('#form-admin-web-add').submit(function(evt){
		evt.preventDefault(); //阻止浏览器默认的submit提交事件
		var shuju = $(this).serialize();//收集form表单信息
		$.ajax({
			url:'{{url("admin/website/add")}}'+ '/'+"{{$website->website_id}}",
			data:shuju,
			dataType:'json',
			type:'post',
			success:function(msg){               
				if(msg.success===true){
					layer.alert('添加数据成功',function(){
                        //①“权限列表”页刷新显示新添加的权限
                       window.location.href=window.location.href;
						
					});
				}else{
				    layer.alert('添加数据失败【'+msg.errorinfo+'】',{icon:5});
				}
			}
		});
	});

});
</script>
@endsection
