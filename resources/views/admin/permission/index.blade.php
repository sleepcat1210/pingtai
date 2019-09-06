@extends("layout.main")
@section("content")
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l">
    <a href="javascript:;" onclick="admin_permission_add('添加权限节点','/admin/permission/add','','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a></span> </div>
	<table class="table table-border table-bordered table-bg table-sort" id="table-sort">
		<thead>
			<tr>
				<th scope="col" colspan="8">权限节点</th>
			</tr>
			<tr class="text-c">				
				<th width="40">ID</th>
				<th width="200">权限名称</th>
                <th>上级</th>
				<th>权限控制器</th>
				<th>权限方法</th>
				<th>权限路由</th>
				<th>权限icon</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($per_list as $k=>$v)
			<tr class="text-c">			
				<td>{{$v->act_id}}</td>
				<td>{!!str_repeat('&nbsp&nbsp&nbsp&nbsp',$v->level)!!}├{{$v->act_name}}</td>
				<td>
				@if($v->permiss)
				{{$v->permiss->act_name}}
				@else
				顶级
				@endif
				</td>
				<td>{{$v->act_c}}</td>
				<td>{{$v->act_m}}</td>
				<td>{{$v->act_r}}</td>
				<td>{{$v->act_icon}}</td>
				<td>
				<a title="编辑" href="javascript:;" onclick="admin_permission_edit('角色编辑','/admin/permission/edit/{{$v->act_id}}','{{$v->act_id}}','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
				 <a title="删除" href="javascript:;" onclick="admin_permission_del(this,'{{$v->act_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
@section("footerjs")
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript">
$('.table-sort').dataTable({
    searching: false,
    bLengthChange: false,
    ordering: false,
    bPaginate: true,
});
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'get',
			url: '{{url("admin/permission/del")}}'+'/'+id,
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
@endsection