<?php


//error_reporting(E_ALL); 
//ini_set('display_errors', '1');


require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;

if( $detect->isMobile() && !$detect->isTablet() ){
	$isMobile = 1;
} else {
	$isMobile = 0;
}


$fm = $_GET['fm'];
$contract_id = $_SESSION['contract_id'];


$sure_to_delete = getlang("您確定要刪除此筆資料嗎?");

$dataTable_de = getDataTable_de();
$Prompt = getlang("提示訊息");
$Confirm = getlang("確認");
$Cancel = getlang("取消");

// $purchaseorder_row = getkeyvalue2($site_db."_info","purchaseorder","auto_seq = '$auto_seq'","status");
// $status =$stock_in_row['status'];
// $status =$purchaseorder_row['status'];



$list_view=<<<EOT
<div class="w-100 p-3">
	<table class="table table-bordered border-dark w-100" id="payable_details_table" style="min-width:1320px;">
		<thead class="table-light border-dark">
			<tr style="border-bottom: 1px solid #000;">
				<th scope="col" class="text-center text-nowrap" style="width:3%;">序</th>
				<th scope="col" class="text-center text-nowrap" style="width:15%;">合約項次</th>
				<th scope="col" class="text-center text-nowrap" style="width:3%;">單位</th>
				<th scope="col" class="text-center text-nowrap" style="width:5%;">單價</th>
				<th scope="col" class="text-center text-nowrap" style="width:5%;">契約數量</th>
				<th scope="col" class="text-center text-nowrap" style="width:7%;">實際(工/次/台/只)數</th>
				<th scope="col" class="text-center text-nowrap" style="width:5%;">複價</th>
				<th scope="col" class="text-center text-nowrap" style="width:15%;">備註</th>
				<th scope="col" class="text-center text-nowrap" style="width:3%;">移除</th>
			</tr>
		</thead>
		<tbody class="table-group-divider">
			<tr>
				<td colspan="8" class="dataTables_empty">資料載入中...</td>
			</tr>
		</tbody>
	</table>
</div>
EOT;



$scroll = true;
if (!($detect->isMobile() && !$detect->isTablet())) {
	$scroll = false;
}
$encoded_purchase_order_id = rawurlencode($purchase_order_id);

$show_payable_details=<<<EOT
<style>
#payable_details_table {
	width: 100% !Important;
	margin: 5px 0 0 0 !Important;
}
</style>

$list_view

<script>
	var oTable;
	$(document).ready(function() {
		$('#payable_details_table').dataTable( {
			"processing": false,
			"serverSide": true,
			"responsive":  {
				details: true
			},//RWD響應式
			"scrollX": '$scroll',
			"paging": false,
			"searching": false,  //禁用原生搜索
			"ordering": false,
			"ajaxSource": "/smarty/templates/$site_db/$templates/sub_modal/project/func09/payable_ms/server_payable_details.php?site_db=$site_db&contract_id=$contract_id&payable_order_id=$payable_order_id&fm=$fm",
			"info": false,
			"language": {
						"sUrl": "$dataTable_de"
					},
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) { 

				

				//顯示自動流水序號
				var seq_no = "";
				seq_no = iDisplayIndex + 1;
				$('td:eq(0)', nRow).html( '<div class="d-flex justify-content-center align-items-center size14 weight text-center" style="height:auto;min-height:32px;">('+seq_no+')</div>' );

				//合約項次
				var seq = "";
				if (aData[0] != null && aData[0] != "")
					seq = '<div class="inline size14 blue02 weight me-2">'+aData[0]+'</div>';

				var work_project = "";
				if (aData[1] != null && aData[1] != "")
					work_project = '<div class="inline size14 weight">'+aData[1]+'</div>';

				$('td:eq(1)', nRow).html( '<div class="d-flex align-items-center" style="height:auto;min-height:32px;">'+seq+work_project+'</div>' );
				
				//單位
				var unit = "";
				if (aData[2] != null && aData[2] != "")
					unit = aData[2];

				$('td:eq(2)', nRow).html( '<div class="d-flex justify-content-center align-items-center size14 text-center" style="height:auto;min-height:32px;">'+unit+'</div>' );

				//單價
				var unit_price = "";
				if (aData[3] != null && aData[3] != "")
					unit_price = number_format(aData[3]);

				$('td:eq(3)', nRow).html( '<div class="d-flex justify-content-center align-items-center size14 text-center text-nowrap" style="height:auto;min-height:32px;">'+unit_price+'</div>' );

				//契約數量
				var contracts_qty = "";
				if (aData[4] != null && aData[4] != "")
					contracts_qty = number_format(aData[4]);

				$('td:eq(4)', nRow).html( '<div class="d-flex justify-content-center align-items-center size14 text-center" style="height:auto;min-height:32px;">'+contracts_qty+'</div>' );


				//實際(工/次/台/只)數
				var actual_qty_url = "openfancybox_edit('/index.php?ch=actual_qty&auto_seq="+aData[7]+"&fm=$fm',300,220,'');";
				if ('$disabled' == "disabled") {
					var actual_qty = '<span class="size14 weight red text-nowrap">'+number_format(aData[5])+'</span>';
				} else {
					var actual_qty = '<button type="button" class="btn btn-light btn-sm px-2 size14 weight red text-nowrap" onclick="'+actual_qty_url+'" title="修改實際(工/次/台/只)數">'+number_format(aData[5])+'</button>';
				}

				$('td:eq(5)', nRow).html( '<div class="d-flex justify-content-center align-items-center text-center" style="height:auto;min-height:32px;">'+actual_qty+'</div>' );

				//複價
				var subtotal = "";
				subtotal = number_format(aData[3]*aData[5]);

				$('td:eq(6)', nRow).html( '<div class="d-flex justify-content-center align-items-center size14 text-center text-nowrap" style="height:auto;min-height:32px;">'+subtotal+'</div>' );

				//備註
				
				var remark_url = "openfancybox_edit('/index.php?ch=remark&auto_seq="+aData[7]+"&fm=$fm',500,220,'');";
				if (aData[6] == null || aData[6] == "") {
					if ('$disabled' == "disabled") {
						var remark = '<span class="size14 weight text-nowrap" style="color:#777777ff;"></span>';
					} else {
						var remark = '<button type="button" class="btn btn-light btn-sm px-2 size14 weight text-nowrap" style="color:#777777ff" onclick="'+remark_url+'" title="備註">請輸入工項對應任務內容</button>';
					}
				} else {
					if ('$disabled' == "disabled") {
						var remark = '<span class="size14 weight text-nowrap" style="color:#777777ff;">' + aData[6] + '</span>';
					} else {
						var remark = '<button type="button" class="btn btn-light btn-sm px-2 size14 weight text-nowrap" style="color:#777777ff" onclick="'+remark_url+'" title="備註">' + aData[6] + '</button>';
					}
				}

				$('td:eq(7)', nRow).html( '<div class="d-flex justify-content-center align-items-center text-center" style="height:auto;min-height:32px;">'+remark+'</div>' );

				//移除

				if ('$disabled' == "disabled") {
					$('td:eq(7)', nRow).html( '' );
				} else {
					var mdel = "payable_details_myDel('"+aData[7]+"');";
					var mdel_btn = '<div class="inline" style="margin: 0 7px 0 7px;"><a href="javascript:void(0);" onclick="'+mdel+'" title="移除"><i class="bi bi-x-lg size12"></i></a></div>';
					
					$('td:eq(8)', nRow).html( '<div class="text-center">'+mdel_btn+'</div>' );
				}

				
				return nRow;
			}
		});
	
		/* Init the table */
		oTable = $('#payable_details_table').dataTable();
		
	} );
	
var payable_details_myDel = function(auto_seq){
	/*
	xajax_payable_detailsDeleteRow(auto_seq);

	return true;
	*/

	Swal.fire({
	title: "您確定要刪除此筆資料嗎?",
	text: "此項作業會刪除所有與此筆記錄有關的資料",
	icon: "question",
	showCancelButton: true,
	confirmButtonColor: "#3085d6",
	cancelButtonColor: "#d33",
	cancelButtonText: "取消",
	confirmButtonText: "刪除"
	}).then((result) => {
		if (result.isConfirmed) {
			xajax_payable_detailsDeleteRow(auto_seq);
		}
	});


};

var payable_details_myDraw = function(){
	var oTable;
	oTable = $('#payable_details_table').dataTable();
	oTable.fnDraw(false);
}

</script>

EOT;

?>