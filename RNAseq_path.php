<?php 
#$test_title  $filename need change $just_file_name
$test_title = "0105_2016_chen";
$filename = "/Local_WORK/alec/0105_2016_chen/C6-I-5_S99_L999_R1_001.fastq,/Local_WORK/alec/0105_2016_chen/D7-3-I-9_S99_L999_R1_001.fastq,/Local_WORK/alec/0105_2016_chen/D10-4-I-10_S99_L999_R1_001.fastq,/Local_WORK/alec/0105_2016_chen/L2_S4_R1_001.fastq,/Local_WORK/alec/0105_2016_chen/D4-4-I-8_S99_L999_R1_001.fastq,/Local_WORK/alec/0105_2016_chen/Skin-2-11-9-I-7_S99_L999_R1_001.fastq";
$filename = Explode(",",$filename);
@$file_len = StrLen($fn);
#orign 18 starting you need to add $test_title len
$filename_len = strlen($test_title); 
@$just_file_name = SubStr($fn,18+$filename_len); #need change base on $filename /Local_WORK/alec/0105_2016_chen/   /home/alec/RNAseq/0105_2016_chen
$gtf = "/Public_Resources/Illumina_Genome/iGenome/Mus_musculus/UCSC/mm10/Annotation/Archives/archive-2012-05-23-16-47-35/Genes/genes.gtf";
$gemone = "/Public_Resources/Illumina_Genome/iGenome/Mus_musculus/UCSC/mm10/Sequence/Bowtie2Index/genome"; 
$Chromosomes = "/Public_Resources/Illumina_Genome/iGenome/Mus_musculus/UCSC/mm10/Sequence/Chromosomes";
$out_01 = "/Local_WORK/alec/quality_trimmer/$just_file_name";
$out_02 = "/Local_WORK/alec/quality_filter/$just_file_name";
$cut_fastq_name = SubStr($just_file_name,0,-6);
$out_03 = $cut_fastq_name."_tophat";
$in_04 = "/Local_WORK/alec/$out_03/accepted_hits.bam";
//samtools view  ./home/alec/RNAseq/L15_S15_R1_001_tophat/accepted_hits.bam | more 
$out_04 = $cut_fastq_name."_cufflinks";
$exist = @File("/Local_WORK/alec/RNAseq/Assemblies.txt");
$file_gtf = Glob("/Local_WORK/alec/*/transcripts.gtf");
$file_gtf = Implode("\n",$file_gtf);
$in_05 = "/Local_WORK/alec/Assemblies.txt";
$out_05 = "/Local_WORK/alec/cuffmerge/$test_title";
$meraged_file = "/Local_WORK/alec/cuffmerge/$test_title/merged.gtf";
$accepted_hits_bam = Glob("/Local_WORK/alec/*/accepted_hits.bam");
$accepted_hits_bam_count = Count($accepted_hits_bam);
$accepted_hits_bam_string = Implode(" ",$accepted_hits_bam);
$out_06 = "/Local_WORK/alec/".$test_title."_finalreport";



















?>