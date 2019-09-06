@extends("layout.main")
@section("content")
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 微信管理 <span class="c-gray en">&gt;</span> 菜单管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="menu_add('添加菜单','/admin/wxmenu/add','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加菜单</a></span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">				
				<th width="80">ID</th>
				<th width="100">菜单名称</th>
				<th width="40">内容</th>
				<th width="90">类型</th>
				<th width="150">排序</th>	
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		@foreach($menu_list as $k=>$v)
			<tr class="text-c">			
				<td>{{$v->menu_id}}</td>
				<td class="text-l">{!!str_repeat('&nbsp&nbsp&nbsp&nbsp',$v->level)!!}├{{$v->menu_name}}</td>			
				<td width="200">{{$v->menu_content}}</td>
				<td>				
				@if($v->menu_event_type ==1)
				普通url
				@elseif($v->menu_event_type ==2)
				图文素材
				@elseif($v->menu_event_type ==3)
				功能
				@endif
				</td>
				<td>{{$v->sort}}</td>			
				<td>
				<a title="编辑" href="javascript:;" onclick="menu_edit('菜单编辑','/admin/wxmenu/edit/{{$v->menu_id}}','{{$v->menu_id}}','','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
				 <a title="删除" href="javascript:;" onclick="menu_del(this,'{{$v->menu_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
		@endforeach
		</tbody>		
	</table>
	</div>
</div>
@endsection
@section("footerjs")
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

/*用户-添加*/
function menu_add(title,url,w,h){
	layer_show(title,url,w,h);
}




/*用户-编辑*/
function menu_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*用户-删除*/
function menu_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "{{url('admin/menu/del')}}"+'/'+id,
			dataType: 'json',			
			headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
			},
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
$('#btns').bind('click',function(){
	$('.table-sort').dataTable().fnDraw(false);
});
</script> 
@endsection



