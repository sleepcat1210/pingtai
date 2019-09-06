@extends("layout.main")
@section("content")
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray"> 
    <span class="l">     
     <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','{{url("admin/roles/add")}}','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> 
	 <span class="r">共有数据：<strong>{{$list->count()}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr>
				<th scope="col" colspan="5">角色管理</th>
			</tr>
			<tr class="text-c">				
				<th width="40">ID</th>
				<th width="200">角色名</th>			
				<th width="300">描述</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($list as $k=>$v)
			<tr class="text-c">
				<td>{{$v->role_id}}</td>
				<td>{{$v->role_name}}</td>			
				<td>{{$v->role_desc}}</td>
				<td class="f-14">
				<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','/admin/roles/edit/{{$v->role_id}}','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
				 <a title="删除" href="javascript:;" onclick="admin_role_del(this,'{{$v->role_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
		@endforeach		
		</tbody>
	</table>
</div>
@endsection
@section("footerjs")
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$('.table-sort').dataTable({
    searching: false,
    bLengthChange: false,
    ordering: false,
    bPaginate: true,
});
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-编辑*/
function admin_role_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$.ajax({
			type: 'get',
			url: '{{url("admin/roles/del")}}'+'/'+id,
			dataType: 'json',
			success: function(data){
				if(data.success===true){
					$(obj).parents("tr").remove();
				    layer.msg('已删除!',{icon:1,time:1000});
				}
				
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script>
@endsection