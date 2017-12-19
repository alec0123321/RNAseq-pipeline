<?php
echo "Please assign name for your testing\n";
echo "For Example : L15_L16_L17 \n ";
$test_title = trim(fgets(STDIN));
echo "Please give the path of the folder\n You need to make the folder for all files you need to work with\n For example = /home/alec/RNAseq/raw/*fastq \n\n";
$filename = trim(fgets(STDIN));
$filename = Glob($filename);
echo "The file's path it's \n";
echo "Starting time... \n";
date_default_timezone_set("Asia/Taipei");
echo date("h:i:sa")."\n";

print_r ($filename);

foreach ($filename as $fn)
{
	$file_len = StrLen($fn);
	$just_file_name = SubStr($fn,23);
	echo "file_name: \t".$just_file_name."\n";
	/////////////////////////////////	//part01 fastq_quality_trimmer
	echo "----------------------------------------------\n";
	echo "fastq_quality_trimmer Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
	//part01 fastq_quality_trimmer
	echo "part01 fastq_quality_trimmer starting...\n";
	echo "..............................................\n";
	$out_01 = "/home/alec/RNAseq/quality_trimmer/$just_file_name";
	exec ("/home/alec/fastx_toolkit/bin/fastq_quality_trimmer -Q 33 -t 20 -l 35 -v -i $fn -o $out_01");
	echo "----------------------------------------------\n";
	echo "fastq_quality_trimmer ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------";
	/////////////////////////////////////Part02 fastq_quality_filter
	echo "----------------------------------------------\n";
	echo "fastq_quality_filter Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
	//Part02 fastq_quality_filter
	echo "Part02 fastq_quality_filter starting...\n";
	echo "..............................................\n";
	$out_02 = "/home/alec/RNAseq/quality_filter/$just_file_name";
	exec("/home/alec/fastx_toolkit/bin/fastq_quality_filter -Q 33 -q 20 -p 70 -v -i $out_01 -o $out_02");
	echo "----------------------------------------------";
	echo "fastq_quality_filter ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}
/////////////////////////////////Part03 tophat
foreach ($filename as $fn)
{
	$file_len = StrLen($fn);
	$just_file_name = SubStr($fn,23);
	//Source
	$gtf = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Annotation/Archives/archive-2015-07-24-10-16-40/Genes/genes.gtf";
	$gemone = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Bowtie2Index/genome"; 
	$Chromosomes = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Chromosomes";
	echo "----------------------------------------------\n";
	echo "tophat Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
	//Part03 tophat
	echo "$just_file_name part03 tophat starting...\n";
	echo "..............................................\n";
	$out_02 = "/home/alec/RNAseq/quality_filter/$just_file_name";
	$just_file_name = SubStr($fn,23);
	$pure_name = SubStr($just_file_name,0,-6);
	$out_03 = $pure_name."_tophat";
	exec ("tophat --b2-very-sensitive -p 65 -G $gtf -o $out_03 $gemone $out_02");
	echo "----------------------------------------------\n";
	echo "tophat ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}	
/////////////////////////////////////Part04 cufflinks
foreach ($filename as $fn)
{
	$file_len = StrLen($fn);
	$just_file_name = SubStr($fn,23);
	//Source
	$gtf = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Annotation/Archives/archive-2015-07-24-10-16-40/Genes/genes.gtf";
	$gemone = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Bowtie2Index/genome"; 
	$Chromosomes = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Chromosomes";
	echo "----------------------------------------------\n";
	echo "cufflinks Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
	//Part04 cufflinks
	echo "$just_file_name part04 cufflinks starting...\n";
	echo "..............................................\n";
	$just_file_name = SubStr($fn,23);
	$pure_name = SubStr($just_file_name,0,-6);
	$out_03 = $pure_name."_tophat";
	$in_04 = "/home/alec/RNAseq/$out_03/accepted_hits.bam";
	//samtools view  ./home/alec/RNAseq/L15_S15_R1_001_tophat/accepted_hits.bam | more 
	$out_04 = $pure_name."_cufflinks";
	exec ("cufflinks -u -b $Chromosomes -p 65 -o $out_04 $in_04 ");
	echo "----------------------------------------------\n";
	echo "cufflinks ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}	
//////////////////Making Assemblies.txt.... 
echo "Making Assemblies.txt....\n";
exec ("rm /home/alec/RNAseq/Assemblies.txt");
$exist = @File("/home/alec/RNAseq/Assemblies.txt");
echo "Making Assemblies.txt....\n";
if (is_file("/home/alec/RNAseq/Assemblies.txt"))
{
	exec("rm /home/alec/RNAseq/Assemblies.txt");
}
else
 	exec ("touch /home/alec/RNAseq/Assemblies.txt"); 
echo "............transcripts.gtf put to Assemblies.txt............ \n";

$file_gtf = Glob("/home/alec/RNAseq/*/transcripts.gtf");
$file_gtf = Implode("\n",$file_gtf);
$file_put = File_Put_Contents("/home/alec/RNAseq/Assemblies.txt",$file_gtf,FILE_APPEND|LOCK_EX);
///home/alec/RNAseq/L16_S16_R1_001_cufflinks/transcripts.gtf
////////////////////////////////////////Part05 cuffmerge
foreach ($filename as $fn)
{
	$file_len = StrLen($fn);
	$just_file_name = SubStr($fn,23);
	//Source
	$gtf = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Annotation/Archives/archive-2015-07-24-10-16-40/Genes/genes.gtf";
	$gemone = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Bowtie2Index/genome"; 
	$Chromosomes = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Chromosomes";
	echo "----------------------------------------------\n";
	echo "cuffmerge Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
	//Part05 cuffmerge
	echo " part05 cuffmerge it's starting...\n";
	echo "..........................................\n";
	$in_05 = "/home/alec/RNAseq/Assemblies.txt";
	$out_05 = "/home/alec/RNAseq/cuffmerge/$test_title";
	//beacuse cuffmerge default make the file name as marged_asm, avoid the conflict using assignment file name
	exec ("cuffmerge -g $gtf -s $Chromosomes -o $out_05 -p 70 $in_05 ");
	echo "----------------------------------------------\n";
	echo "cuffmerge ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}	
///////////////////////////////////////////Part06 cuffdiff
echo "----------------------------------------------\n";
echo "cuffdiff Starting time... \n";
date_default_timezone_set("Asia/Taipei");
echo date("h:i:sa")."\n";
echo "----------------------------------------------\n";
echo " part06 cuffdiff it's starting...\n";
echo "..........................................\n";
$gtf = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Annotation/Archives/archive-2015-07-24-10-16-40/Genes/genes.gtf";
$gemone = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Bowtie2Index/genome"; 
$Chromosomes = "/Public_Resources/Illumina_Genome/iGenome/Rattus_norvegicus/UCSC/rn6/Sequence/Chromosomes";
$meraged_file = "/home/alec/RNAseq/cuffmerge/$test_title/merged.gtf";
$accepted_hits_bam = Glob("/home/alec/RNAseq/*/accepted_hits.bam");
$accepted_hits_bam_count = Count($accepted_hits_bam);
$accepted_hits_bam_string = Implode(" ",$accepted_hits_bam);
echo "...........Total case = $accepted_hits_bam_count...........\n";
///making $case array 
$case = Array();
for ($i=1;$i<=$accepted_hits_bam_count;$i++)
	$case[] = "A".$i;
$case_name_for_A = Implode(",",$case);
$out_06 = "/home/alec/RNAseq/".$test_title."_finalreport";
exec ("cuffdiff -o $out_06 -b $Chromosomes -p 70 -L $case_name_for_A -u $meraged_file $accepted_hits_bam_string");
echo "----------------------------------------------\n";
echo "cuffdiff ending time... \n";
echo date("h:i:sa")."\n";
echo "----------------------------------------------";
echo "The accepted_hits.bam path it's in:\n $accepted_hits_bam_string\n";
echo "............................................................\n";
echo "............................................................\n";
echo "............................................................\n";
echo "............................................................\n";
echo "............................................................\n";
echo "\n.............Making Final report.............\n";
////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
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
$out_06 = "/home/alec/RNAseq/".$test_title."_finalreport";
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
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
$R = Glob("*R");
$R = Implode (" ",$R);
$png = Glob("*png");
$png = Implode(" ",$png);
$txt = Glob("*txt");
$txt = Implode(" ",$txt);
echo $R.$png.$txt."\n";
exec ("cp $R $test_title");
exec ("cp $png $test_title");
exec ("cp $txt $test_title");

?>
//////////////////////////////////////////////////////////////

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

		 
		 