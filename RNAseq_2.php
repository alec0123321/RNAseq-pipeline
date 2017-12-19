<?php
include("2_path.php");
$file = File_Get_Contents($out_06."/genes.fpkm_tracking");
$file_split = Explode("\n",$file);
$file_split1 = array_shift($file_split);
foreach ($file_split as $fs)
{
	$file = Explode("\t",$fs);
	$gene = Explode(",",$file[4]);
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus1( $gen , $file[9] ); 
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus2( $gen , $file[13] ); 
	foreach ($gene as $gen)
	  if (StrLen($gen) > 2)
		plus3( $gen , $file[17] ); 
}
$gene = Array_Keys($GLOBAL1);
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
$txt = Glob("/home/alec/RNAseq/*.txt");
foreach ($txt as $t)
{
	$t_shirt = substr($t,18,-4);
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
/////////////////////////////////////////////////////////////
$R = Glob("/home/alec/RNAseq/result_*.R");
print_r ($R);
foreach ($R as $r)
{
	$shrit = substr($r,18);
	exec("Rscript $shrit");
}
?>

                       _oo0oo_
                      o8888888o
                      88" . "88
                      (| -_- |)
                      0\  =  /0
                    ___/`---'\___
                  .' \\|     |//  '.
                 / \\|||  иц  |||// \
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