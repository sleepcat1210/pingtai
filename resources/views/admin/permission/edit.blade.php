@extends("layout.main")
@section("content")
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$permission->act_name}}" placeholder="" id="roleName" name="act_name">
			</div>
		</div>
        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pid" class="select">
				    <option value="0"
					@if($permission->pid==0)
					selected="selected"
					@endif
					>顶级</option>	
					@foreach($act_list as $k=>$v)
					<option value="{{$v->act_id}}" 
					@if($permission->pid==$v->act_id)
					selected="selected"
					@endif
					>{!!str_repeat('&nbsp&nbsp&nbsp&nbsp',$v->level)!!}├{{$v->act_name}}</option>	
					@endforeach				
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">控制器：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="act_c" value="{{$permission->act_c}}">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">操作方法：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="act_m" value="{{$permission->act_m}}">
			</div>
		</div>
        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">路由：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="act_r" value="{{$permission->act_r}}">
			</div>
		</div>
        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">小图标：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="act_icon" value="{{$permission->act_icon}}">
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
	
	
	$("#form-admin-role-add").validate({
		rules:{
			act_name:{
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
			url:'{{url("admin/permission/edit")}}'+'/'+{{$permission->act_id}},
			data:shuju,
			dataType:'json',
			type:'post',
			success:function(msg){               
				if(msg.success===true){
					layer.alert('添加数据成功',function(){
                        //①“权限列表”页刷新显示新添加的权限
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