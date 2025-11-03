<?php

//error_reporting(E_ALL); 
//ini_set('display_errors', '1');


session_start();

$memberID = $_SESSION['memberID'];
$powerkey = $_SESSION['powerkey'];


@include_once("/website/class/".$site_db."_info_class.php");

//載入公用函數
@include_once '/website/include/pub_function.php';


$m_location		= "/website/smarty/templates/".$site_db."/".$templates;
$m_pub_modal	= "/website/smarty/templates/".$site_db."/pub_modal";


$sid = "";
if (isset($_GET['sid']))
	$sid = $_GET['sid'];

	//程式分類
	$ch = empty($_GET['ch']) ? 'default' : $_GET['ch'];
	switch($ch) {
		case 'ch_contract':
			$title = "合約工作項目選單";
			if (empty($sid))
				$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/ch_contract.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'add':
			$title = "新增項目";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable_add.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'edit':
			$title = "編輯項目";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable_modify.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'ch_employee':
			$title = "員工名單";
			if (empty($sid))
				$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/ch_employee.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'payable_detail_add':
			$title = "新增料件";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable_detail_add.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'payable_detail_modify':
			$title = "編輯料件";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable_detail_modify.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'actual_qty':
			$title = "實際(工/次/台/只)數";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/actual_qty_modify.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		case 'remark':
			$title = "備註";
			$sid = "view01";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable_remark_modify.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
		default:
			if (empty($sid))
				$sid = "mbpjitem";
			$modal = $m_location."/sub_modal/project/func09/payable_ms/payable.php";
			include $modal;
			$smarty->assign('show_center',$show_center);
			$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
			break;
	};

?>