<?php
include("RNAseq_path.php");
echo $test_title."\n";
print_r ($filename);
echo "Starting time... \n";
date_default_timezone_set("Asia/Taipei");
echo date("h:i:sa")."\n";
foreach ($filename as $fn)
{
	echo $fn."\n";
    include("RNAseq_path.php");
	echo "file_name: \t".$just_file_name."\n";
	  #part01 02 fastq_quality_trimmer _filter
	echo "fastq_quality_trimmer_filter Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	exec ("/home/alec/fastx_toolkit/bin/fastq_quality_trimmer -Q 33 -t 20 -l 35 -v -i $fn -o $out_01");
	exec("/home/alec/fastx_toolkit/bin/fastq_quality_filter -Q 33 -q 20 -p 70 -v -i $out_01 -o $out_02");
	echo "fastq_quality_trimmer_filter ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}
foreach ($filename as $fn)
{
	include("RNAseq_path.php");	
	echo "file_name: \t".$just_file_name."\n";
	  #Part03 tophat
	echo "tophat Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	exec ("tophat --b2-very-sensitive -p 70 -G $gtf -o $out_03 $gemone $out_02");
	echo "tophat ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}
foreach ($filename as $fn)
{
	include("RNAseq_path.php");	
	echo "file_name: \t".$just_file_name."\n";
	  #Part04 cufflinks
	echo "cufflinks Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	exec ("cufflinks -u -b $Chromosomes -p 70 -o $out_04 $in_04 ");
	echo "----------------------------------------------\n";
	echo "cufflinks ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}
	#Making Assemblies.txt.... 
echo "Making Assemblies.txt....\n";
if (is_file("/Local_WORK/alec/Assemblies.txt"))
	exec("rm /Local_WORK/alec/Assemblies.txt");
else
 	exec ("touch /Local_WORK/alec/Assemblies.txt"); 
$file_put = File_Put_Contents("/Local_WORK/alec/Assemblies.txt",$file_gtf,FILE_APPEND|LOCK_EX);
	#Part05 cuffmerge
foreach ($filename as $fn)
{
	include("RNAseq_path.php");	
	echo "file_name: \t".$just_file_name."\n";
	  #Part05 cuffmerge
	echo "cuffmerge Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	exec ("cuffmerge -g $gtf -s $Chromosomes -o $out_05 -p 70 $in_05 ");
	echo "cuffmerge ending time... \n";
	echo date("h:i:sa")."\n";
	echo "----------------------------------------------\n";
}
echo "cuffdiff Starting time... \n";
date_default_timezone_set("Asia/Taipei");
echo date("h:i:sa")."\n";
	#making $case array 
$case = Array();
for ($i=1;$i<=$accepted_hits_bam_count;$i++)
	$case[] = "A".$i;
$case_name_for_A = Implode(",",$case);
echo "$accepted_hits_bam_string";
exec ("cuffdiff -o $out_06 -b $Chromosomes -p 70 -L $case_name_for_A -u $meraged_file $accepted_hits_bam_string");
echo "cuffdiff ending time... \n";
echo date("h:i:sa")."\n";
echo "----------------------------------------------";
echo "The accepted_hits.bam path it's in:\n $accepted_hits_bam_string\n";
echo "\n.............Making Final report.............\n";
?>

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



