<?php
require './init.php';
//获取待查看的文章ID
$id = I('id', 'get', 'id');

//更新文章阅读量
db_query('UPDATE `cms_article` SET `views`=`views`+1 WHERE `id`=? AND `shows`=\'yes\' AND `views`<4294967295', 'i', $id);

//获取文章数据
$data = [
	'head' => [
		'title' => '查看文章',
		'keywords' => 'PHP,内容,管理',
		'description' => 'PHP内容管理系统'
	],
	//顶部导航
	'nav' => [
		'curr' => 'show',
		'list' => module_category_nav()
	],
	//文章内容
	'show' => module_article_show($id),
	//侧边栏
	'sidebar' => [
		'category' => module_category(),
		'history' => module_history($id),
		'hot' => module_hot()
	]
];

if($data['show']){
	//获取文章所属分类数据
	$data['show']['cname'] = module_category_name($data['show']['cid']);
	$data['nav']['curr'] = 'cid_'.module_category_top($data['show']['cid']);
	//查询上一篇和下一篇
	$data['show']['change'] = [
		'prev' => db_fetch(DB_ROW, "SELECT `id`,`title` FROM `cms_article` WHERE `id`<? AND `shows`='yes' ORDER BY `id` DESC LIMIT 1", 'i', $id),
		'next' => db_fetch(DB_ROW, "SELECT `id`,`title` FROM `cms_article` WHERE `id`>? AND `shows`='yes' LIMIT 1", 'i', $id)
	];
	//准备头部信息
	$data['head'] = [
		'title' => $data['show']['title'],
		'keywords' => $data['show']['keywords'],
		'description' => $data['show']['description']
	];
	$data['sidebar']['category'] = module_category_sidebar($data['show']['cid']);
}else{
	$data['show'] = [];
	$data['sidebar']['category'] = module_category_sidebar();
}

//载入HTML模板
require './view/layout.html';
