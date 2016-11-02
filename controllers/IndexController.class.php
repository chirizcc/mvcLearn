<?php

class IndexController
{

	public function index()
	{
		// echo 'Index index';
		global $smarty;
		$smarty->display('Index/index.html');
	}

}