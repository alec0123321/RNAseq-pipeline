<?php
require("RNAseq_path.php");
echo $test_title."\n";
print_r ($filename);
echo "Starting time... \n";
date_default_timezone_set("Asia/Taipei");
echo date("h:i:sa")."\n";
foreach ($filename as $fn)
{
	echo "$test_title";
	echo "file_name: \t".$just_file_name."\n";
	  #part01 02 fastq_quality_trimmer _filter
	echo "fastq_quality_trimmer_filter Starting time... \n";
	date_default_timezone_set("Asia/Taipei");
	echo date("h:i:sa")."\n";
	/* exec ("/home/alec/fastx_toolkit/bin/fastq_quality_trimmer -Q 33 -t 20 -l 35 -v -i $fn -o $out_01");
	echo "Part02 fastq_quality_filter starting...\n";
	exec("/home/alec/fastx_toolkit/bin/fastq_quality_filter -Q 33 -q 20 -p 70 -v -i $out_01 -o $out_02");
	echo "fastq_quality_trimmer_filter ending time... \n"; */

}




















?>