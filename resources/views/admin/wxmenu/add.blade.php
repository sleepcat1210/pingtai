@extends("layout.main")
@section("content")
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-menu-add">
                {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">上级菜单：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="pid">
				<option value="0">顶级</option>
                                    @foreach($menu_list as $k=>$v)
					<option value="{{$v->menu_id}}">{{$v->menu_name}}</option>
                                    @endforeach
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" name="menu_name">
			</div>
		</div>  
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">菜单类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="menu_event_type">
				<option value="1">普通url</option>                  
				<option value="2">图文素材</option>                  
				<option value="3">功能</option>                  
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单内容：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value=""  name="menu_content">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  name="sort" id="email">
			</div>
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

	$("#form-menu-add").validate({
		rules:{
			menu_name:{
				required:true,
				minlength:2,
				maxlength:16
			},	
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		
	});
          $('#form-menu-add').submit(function(evt){
		evt.preventDefault(); //阻止浏览器默认的submit提交事件
		var shuju = $(this).serialize();//收集form表单信息
		$.ajax({
			url:'{{url("admin/wxmenu/add")}}',
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

