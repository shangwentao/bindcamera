<?php
	function deal_html($str)
	{
		if($str!=''){
			$str = trim(strip_tags($str));
			$str = preg_replace('~<([a-z]+?)\s+?.*?>~i','<$1>',$str);
			return $str;
		}
		return '';
	}
?>