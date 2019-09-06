@extends("layout.main")
@section("content")
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text"  value="{{$datemin}}"onfocus="WdatePicker()" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" value="{{$datemax}}" onfocus="WdatePicker()" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="手机号" id="user_tel" name="user_tel">
		<button type="submit" class="btn btn-success radius" id="btns" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="member_add('添加用户','/admin/members/add','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">				
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="40">性别</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>				
				<th width="130">加入时间</th>
				<th width="70">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>		
	</table>
	</div>
</div>
@endsection
@section("footerjs")
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
$(function(){
	mydatatable = $('.table-sort').dataTable({
	"lengthMenu": [ 3,10, 20, 30 ],
        "paging":true,
        "info":true,
        "searching":false,
        "ordering":true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [{
            "targets": [1,2,3,4,5,6,7],
            "orderable": false
        }],
        "processing":true,
        "serverSide": true,
        "ajax": {
            "url": "{{url('admin/members')}}",
            "type": "post",
            'headers': {
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
			},
			'data':function(d){
				d.datemin=$('#datemin').val();
				d.datemax=$('#datemax').val();
				d.user_tel=$('#user_tel').val();
			}
        },
        "columns": [           
            {'data':'uid'},
            {'data':'user_name'},
            {'data':'sex'},
            {'data':'user_tel'},
            {"data": "user_email"},           
            {'data':'created_at'},
            {'data':'user_status'},
            {"defaultContent": "","className":"td-manager"},
		],
	    "createdRow":function(row,data,dataIndex){
            //数据填充的回调函数，每个"tr"被绘制的时候会调用该函数
			//row:被绘制的tr的dom对象
			//data:该tr行对应的一条数据记录信息
			//dataIndex:是该tr的下表索引号码
			if(data.user_status==1){
				var status ='<a style="text-decoration:none" onClick="member_stop(this,'+data.uid+')" href="javascript:;" title="停用"><span class="label label-success radius">已启用</span></a>';
			}else{				
				var status='<a style="text-decoration:none" onClick="member_start(this,'+data.uid+')" href="javascript:;" title="启用"><span class="label radius">已停用</span></a>';				
			}
			$(row).find('td:eq(6)').html(status);
			 var anniu = '<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'/admin/members/edit/'+data.uid+'\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="member_del(this,'+data.uid+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
			//把anniu填充给最后一个td里边
			$(row).find('td:eq(7)').html(anniu);
			if(data.sex==1){				
				$(row).find('td:eq(2)').html('男');
			}else if(data.sex==2){
                            $(row).find('td:eq(2)').html('女');
                        }else{
			  $(row).find('td:eq(2)').html('保密');
			}
			$(row)[0].className="text-c";
			// console.log($(row));
			
		}
	});
	
});

/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-查看*/
function member_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-停用*/
function member_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
				$(obj).remove();
				layer.msg('已停用!',{icon: 5,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*用户-启用*/
function member_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*用户-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "{{url('admin/members/del')}}"+'/'+id,
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



