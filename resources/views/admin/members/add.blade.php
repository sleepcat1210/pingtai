@extends("layout.main")
@section("content")
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
                {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="username" name="user_name">
			</div>
		</div>            
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder=""  name="user_password">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-1" value="1" checked>
					<label for="sex-1">男</label>
				</div>
				<div class="radio-box">
                                    <input type="radio" id="sex-2" name="sex" value="2">
					<label for="sex-2">女</label>
				</div>
				<div class="radio-box">
                                    <input type="radio" id="sex-3" name="sex" value="0">
					<label for="sex-3">保密</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="mobile" name="user_tel">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="@" name="user_email" id="email">
			</div>
		</div>		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">会员等级：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="members_level">
                                    @foreach($level as $k=>$v)
					<option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                    @endforeach
				</select>
				</span> </div>
		</div>		
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>
@endsection
@section("footerjs")
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	$("#form-member-add").validate({
		rules:{
			user_name:{
				required:true,
				minlength:2,
				maxlength:16
			},
			user_password:{
				required:true,
				minlength:2,
				maxlength:16
			},
			sex:{
				required:true,
			},
			user_tel:{
				required:true,
				isMobile:true,
			},
			user_email:{
				required:true,
				email:true,
			},			

		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		
	});
          $('#form-member-add').submit(function(evt){
		evt.preventDefault(); //阻止浏览器默认的submit提交事件
		var shuju = $(this).serialize();//收集form表单信息
		$.ajax({
			url:'{{url("admin/members/add")}}',
			data:shuju,
			dataType:'json',
			type:'post',
			success:function(msg){               
				if(msg.success===true){
					layer.alert('添加数据成功',function(){                        
                        parent.window.location.href=parent.window.location.href;
						layer_close();//②关闭当前层
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

