<?php
$GLOBAL1 = array();
$GLOBAL12 = array();
$GLOBAL10 = array();
$GLOBAL2 = array();
$GLOBAL22 = array();
$GLOBAL20 = array();
$GLOBAL3 = array();
$GLOBAL32 = array();
$GLOBAL30 = array();
function plus1( $gene_name , $expression)
{
	global $GLOBAL1;
	global $GLOBAL12;
	global $GLOBAL10;
	if ( @$GLOBAL1[$gene_name] != "" )
	{
		$GLOBAL10[$gene_name] += $expression;
		$GLOBAL1[$gene_name] += log(1+$expression,2);
		$GLOBAL12[$gene_name] += log(1+$expression,10);
	}
		
	else
	{
		$GLOBAL10[$gene_name] = $expression;
		$GLOBAL1[$gene_name] = log(1+$expression,2);
		$GLOBAL12[$gene_name] = log(1+$expression,10);
	}
		
	//echo "\t[" . $gene_name ."] ----> ". $GLOBAL1[$gene_name];
}

function plus2( $gene_name , $expression )
{
	global $GLOBAL2;
	global $GLOBAL22;
	global $GLOBAL20;
	if ( @$GLOBAL2[$gene_name] != "" )
	{
		$GLOBAL20[$gene_name] += $expression;
		$GLOBAL2[$gene_name] += log(1+$expression,2);
		$GLOBAL22[$gene_name] += log(1+$expression,10);
	}
		
	else
	{
		$GLOBAL20[$gene_name] = $expression;
		$GLOBAL2[$gene_name] = log(1+$expression,2);
		$GLOBAL22[$gene_name] = log(1+$expression,10);
	}
	//echo "\t[" . $gene_name ."] ----> ". $GLOBAL2[$gene_name];
}

function plus3( $gene_name , $expression )
{ 
	global $GLOBAL3;
	global $GLOBAL32;
	global $GLOBAL30;
	if ( @$GLOBAL3[$gene_name] != "" )
	{
		$GLOBAL30[$gene_name] += $expression;
		$GLOBAL3[$gene_name] += log(1+$expression,2);
		$GLOBAL32[$gene_name] += log(1+$expression,10);
	}
		
	else
	{
		$GLOBAL30[$gene_name] = $expression;
		$GLOBAL3[$gene_name] = log(1+$expression,2);
		$GLOBAL32[$gene_name] = log(1+$expression,10);
	}
		
	
	//echo "\t[" . $gene_name ."] ----> ". $GLOBAL3[$gene_name];
}






?>