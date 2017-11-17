<?php
function xmlGetValue(&$xmlElement, $key, $count=1)
{
	if ($xmlElement == null) return '';

	$els = $xmlElement->getElementsByTagName($key);
	$value = '';
	$i = 0;
	foreach($els as $elem)
	{
		$value .= $elem->nodeValue;

		++$i;
		if ($i == $count)
			break;
	}
	return $value;
}

function xmlGetLevel($xmlParent, $xmlChild)
{
	$level = 1;
	$elm = $xmlChild;
	for (;;)
	{
		if ($elm == null) return -1;
		if ($elm->parentNode === $xmlParent) return $level;

		++$level;
		$elm = $elm->parentNode;
	}
}

function xmlGetElement(&$xmlElement, $key, $level=1, $count=1)
{
	if ($xmlElement == null) return null;
	
	$els = $xmlElement->getElementsByTagName($key);
	$c = 1;
	foreach($els as $elem)
	{
		$l = xmlGetLevel($xmlElement, $elem);
		if ($l == $level)
		{
			if ($c == $count) 
				return $elem;
			++$c;
		}
	}
	return null;    
}

function xmlGetElementEcho(&$xmlElement, $key, $level=1, $count=1)
{
    if ($xmlElement == null) 
	{
		echo "KO : xmlGetElement : $key null ".'<BR>';
		return null;
	}
	
	$els = $xmlElement->getElementsByTagName($key);
	$c = 1;
	foreach($els as $elem)
	{
		$l = xmlGetLevel($xmlElement, $elem);
		if ($l == $level)
		{
			if ($c == $count) 
			{
				echo "Success : xmlGetElement : $key ".'<BR>';
				return $elem;
			}
			++$c;
		}
		echo "KO : xmlGetElement : $key / Level $l / Value ".$elem->nodeValue.'<BR>';
	}

	echo "KO : xmlGetElement : $key => NULL ".'<BR>';
    return null;    
}

?>