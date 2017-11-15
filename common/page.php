<?php

//获取SQL分页 Limit
function page_sql($page, $size){
	return ($page-1) * $size . ',' . $size;
}

//获取分页HTML
function page_html($total, $page, $size){
	//计算总页数
	$maxpage = max(ceil($total/$size), 1);
	//如果不足2页，则不显示分页导航
	if($maxpage <= 1) return '';
	//获取URL参数字符串
	$url = page_url();
	$url = $url ? "?$url&page=" : '?page=';
	//拼接 首页
	$first = "<a href=\"{$url}1\">首页</a>";
	//拼接 上一页
	$prev = ($page==1) ? '<span>上一页</span>' :
			'<a href="'.$url.($page-1).'">上一页</a>';
	//拼接 下一页
	$next = ($page==$maxpage) ? '<span>下一页</span>' :
			'<a href="'.$url.($page+1).'">下一页</a>';
	//拼接 尾页
	$last = "<a href=\"{$url}{$maxpage}\">尾页</a>";
	//组合最终样式
	return "$first $prev $next $last 当前为：$page/$maxpage";
}

//生成URL参数
function page_url(){
	$params = $_GET;
	unset($params['page']);
	return http_build_query($params);	
}



