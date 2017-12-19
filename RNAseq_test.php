<?php
//you need to change 
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



$file = File_Get_Contents($argv[1]);

$file_split = Explode("\n",$file);

$file_split1 = array_shift($file_split);

foreach ($file_split as $fs)
{
	$file = Explode("\t",$fs);

	$gene = Explode(",",$file[4]);
	
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus1( $gen , $file[9] ); 
		
	//echo "\t||";
	
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus2( $gen , $file[13] ); 
		
	//echo "\t||";
	
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus3( $gen , $file[17] ); 
	
	//echo "\n";
}

/* print_r ($GLOBAL1);
print_r ($GLOBAL12);
print_r ($GLOBAL2);
print_r ($GLOBAL22);
print_r ($GLOBAL3);
print_r ($GLOBAL32); */

$gene = Array_Keys($GLOBAL1);

print_r ($gene);
//log2FC A
File_Put_Contents("result_A.txt","gene_short_name\t A2_FPKM\t A1_FPKM\t log2FC\t log10ES \n",FILE_APPEND);

foreach ($gene as $name)
{
	$a =$name."\t".$GLOBAL20[$name]."\t".$GLOBAL10[$name]."\t".($GLOBAL2[$name]-$GLOBAL1[$name])."\t".($GLOBAL22[$name]*$GLOBAL12[$name])."\n";
	File_Put_Contents("result_A.txt",$a,FILE_APPEND);
}
//log2FC B
File_Put_Contents("result_B.txt","gene_short_name\t A3_FPKM\t A2_FPKM\t log2FC\t log10ES  \n",FILE_APPEND);

foreach ($gene as $name)
{
	$a =$name."\t".$GLOBAL30[$name]."\t".$GLOBAL20[$name]."\t".($GLOBAL3[$name]-$GLOBAL2[$name])."\t".($GLOBAL32[$name]*$GLOBAL22[$name])."\n";
	File_Put_Contents("result_B.txt",$a,FILE_APPEND);
}
//log2FC C
File_Put_Contents("result_C.txt","gene_short_name\t A3_FPKM\t A1_FPKM\t log2FC\t log10ES \n",FILE_APPEND);

foreach ($gene as $name)
{
	$a =$name."\t".$GLOBAL30[$name]."\t".$GLOBAL10[$name]."\t".($GLOBAL3[$name]-$GLOBAL1[$name])."\t".($GLOBAL32[$name]*$GLOBAL12[$name])."\n";
	File_Put_Contents("result_C.txt",$a,FILE_APPEND);
}
/////////////////////////////////////////////////

$txt = Glob("/home/alec/RNAseq/test/*txt");
foreach ($txt as $t)
{
	$t_shirt = substr($t,23,-4);
	$name = $t_shirt.".R";
	File_Put_Contents("$name","gene_list<-read.table(\"$t\",header=T,row.names=1,sep=\"\\t\",blank.lines.skip = TRUE)\n",FILE_APPEND);
	File_Put_Contents("$name","require(ggplot2)\n",FILE_APPEND);
	File_Put_Contents("$name","gene_list \$threshold=as.factor(abs(gene_list\$log2FC)>0.58499&gene_list\$log10ES>=1)\n",FILE_APPEND);
	File_Put_Contents("$name","png(\"$t_shirt.png\",width=20,height=20,unit=\"cm\",res=300)\n",FILE_APPEND);
	File_Put_Contents("$name","g=ggplot(data=gene_list,aes(x=log2FC,y=log10ES,colour=threshold))+\n",FILE_APPEND);
	File_Put_Contents("$name","geom_point(alpha=0.4,size=1.75)+\n",FILE_APPEND);
	File_Put_Contents("$name","theme(legend.position=\"none\")+\n",FILE_APPEND);
	File_Put_Contents("$name","xlim(c(-10,10))+ylim(c(0,4.5))+\n",FILE_APPEND);
	File_Put_Contents("$name","xlab(\"log2?Fold?Change\")+ylab(\"log10?Expression?sum\")\n",FILE_APPEND);
	File_Put_Contents("$name","g\n",FILE_APPEND);
	File_Put_Contents("$name","dev.off()\n",FILE_APPEND);
	File_Put_Contents("$name","q()\n",FILE_APPEND);
}
$R = Glob("/home/alec/RNAseq/test/result_*.R");
foreach ($R as $r)
{
	$shrit = substr($r,23);
	exec("Rscript $shrit");
}
//////////////////////////////////////////////////////////////

?>
/* 		__  	   __		  ____  ______                      			
  	 /\ \     | |    | ___||  ____|        
  	/ /\ \    | |    |	|_ | |       
	 / /__\ \   | |    |  __|| |             
  / /    \ \  | |___||  |__| |____                  
_/_/			\_\_|_____||_____|______|   */
			
/*
                       _oo0oo_
                      o8888888o
                      88" . "88
                      (| -_- |)
                      0\  =  /0
                    ___/`---'\___
                  .' \\|     |//  '.
                 / \\|||  卍  |||// \
                / _||||| -:- |||||_ \
               |   | \\\  -  /// |   |
               | \_|  ''\---/''  |_/ |
               \  .-\__  '-'   __/-. /
             ___'. .'  /--.--\   '. .'___
          ."" '<  '.___\_<|>_/___.' >' "" .
         | | :  '- \'.;'\ _ /';.'/ - ' : | |
         \  \ '_.   \_ __\ /__ _/   .-' /  /
     ====='-.____'.___ \_____/___.-'___.-'=====
                        '=---='


     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/