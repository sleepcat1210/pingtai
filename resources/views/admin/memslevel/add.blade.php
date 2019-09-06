@extends("layout.main")
@section("content")
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>等级名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder=""  name="level_name">
			</div>
		</div>
                <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>消费金额：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder=""  name="amount">
			</div>
		</div>
                 <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>折扣率：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder=""  name="discount">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
                            <textarea  class="textarea"  name="describe"></textarea>
			</div>
		</div>		
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3 text-c">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-level-save"><i class="icon-ok"></i> 确定</button>
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
			level_name:{
				required:true,
			},
                        amount:{
				required:true,
			},
                        discount:{
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
			url:'{{url("admin/memslevel/add")}}',
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