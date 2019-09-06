@extends("layout.main")
@section("content")
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$roles->role_name}}" placeholder="" id="roleName" name="role_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="role_desc" value="{{$roles->role_desc}}">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
			@foreach($per_list as $k=>$v)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v['act_id']}}" name="act_id[]" id="user-Character-0"
							@if(in_array($v['act_id'],$roles_per))
							checked="checked"
							@endif
							>
							{{$v['act_name']}}</label>
					</dt>
					<dd>
						@foreach($v['son'] as $sk=>$sv)
						<dl class="cl permission-list2">
							<dt>
								<label class="">
									<input type="checkbox" value="{{$sv['act_id']}}" name="act_id[]" id="user-Character-0-0"
									@if(in_array($sv['act_id'],$roles_per))
									checked="checked"
									@endif
									>
									{{$sv['act_name']}}</label>
							</dt>
							
							<dd>
							@foreach($sv['son'] as $kk=>$vv)
								<label class="">
									<input type="checkbox" value="{{$vv['act_id']}}" name="act_id[]" id="user-Character-0-0-0"
									@if(in_array($vv['act_id'],$roles_per))
									checked="checked"
									@endif
									>
									{{$vv['act_name']}}</label>
							@endforeach							
							</dd>
						</dl>
						@endforeach
					</dd>
					
				</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3 text-c">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>

@endsection
@section("footerjs")
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	
	$("#form-admin-role-add").validate({
		rules:{
			role_name:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",	
	});
    $('#form-admin-role-add').submit(function(evt){
		evt.preventDefault(); //阻止浏览器默认的submit提交事件
		var shuju = $(this).serialize();//收集form表单信息
		$.ajax({
			url:'{{url("admin/roles/edit")}}'+'/'+"{{$roles->role_id}}",
			data:shuju,
			dataType:'json',
			type:'post',
			success:function(msg){               
				if(msg.success===true){
					layer.alert('编辑数据成功',function(){
                        //①“权限列表”页刷新显示新添加的权限
                        parent.window.location.href=parent.window.location.href;
						layer_close();//②关闭当前层
					});
				}else{
				    layer.alert('编辑数据失败【'+msg.errorinfo+'】',{icon:5});
				}
			}
		});
	});
});
</script>
@endsection