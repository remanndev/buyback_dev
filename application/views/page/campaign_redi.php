<?php
$this->campaign_url = base_url('campaign/donation/redi'); 
?>
<link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable.min.css" />
<style>
.font-pretendard { font-family: 'Pretendard Variable'; font-weight: 300; }
.fw_400 { font-weight: 400; }
.fw_500 { font-weight: 500; }
.fw_600 { font-weight: 600; }
.fw_700 { font-weight: 700; }
.fw_800 { font-weight: 800; }

.mt_10 { margin-top: 10px; }
.mt_20 { margin-top: 20px; }
.mt_30 { margin-top: 30px; }
.mt_40 { margin-top: 40px; }
.mt_50 { margin-top: 50px; }
.mt_60 { margin-top: 60px; }
.mt_70 { margin-top: 70px; }
.mt_80 { margin-top: 80px; }

.color_ffffff { color: #ffffff; }
.color_ffde77 { color: #ffde77; }
.color_fdf9d4 { color: #fdf9d4; }
.color_272724 { color: #272724; }
.color_f1d69f { color: #f1d69f; }
.color_00a4ff { color: #00a4ff; }
.color_97ddff { color: #97ddff; }
.color_0091d9 { color: #0091d9; }

.bg-blue-00a4ff { background-color: #00a4ff; }

/* ._pc */
.fs_1 { font-size: 40px; color: #ffffff; font-weight: 600; }
.fs_2 { font-size: 54px; color: #ffffff; font-weight: 700; }
.fs_3 { font-size: 32px; color: #ffffff; }
.fs_3B { font-size: 32px; color: #272724; font-weight: 500; }
.fs_4 { font-size: 23px; color: #ffffff; }
.fs_5 { font-size: 24px; color: #272724; font-weight: 600; }

/*
.fs_61 { font-size: 100px; color: #00a4ff; font-weight: 900; line-height: 0.4; }
.fs_62 { font-size: 58px; color: #b4b4b4; font-weight: 400; line-height: 0.67;}
.fs_63 { font-size: 27px; color: #00a4ff; font-weight: 500; line-height: 2; margin-left: 20px; }
*/
.fs_61 { font-size: 96px; color: #00a4ff; font-weight: 900; line-height: 1; width: 76px; text-align: center; }
.fs_62 { font-size: 48px; color: #00a4ff; font-weight: 600; line-height: 1.1; }
.fs_63 { font-size: 23px; color: #272724; font-weight: 400; line-height: 1.5; }

.fs_7 { font-size: 24px; color: #ffffff; font-weight: 600; }
.fs_8 { font-size: 43px; color: #272724; font-weight: 800; }

.fs_9 { font-size: 24px; color: #00a4ff; font-weight: 600; }
.fs_10 { font-size: 43px; color: #272724; font-weight: 800; }

.fs_11 { font-size: 24px; color: #272724; font-weight: 600; }
.fs_12 { font-size: 43px; color: #272724; font-weight: 800; line-height: 1.3; }
.fs_13 { font-size: 24px; color: #272724; font-weight: 500; }
.fs_14 { font-size: 24px; color: #272724; font-weight: 600; line-height: 1.67; }
.fs_15 { font-size: 43px; color: #272724; font-weight: 800; line-height: 1.3;}

.lh_14 { line-height: 1.4; }
.lh_15 { line-height: 1.5; }
.lh_16 { line-height: 1.6; }

/* ._mobile */
.fs14px {font-size: 14px;}
.fs16px {font-size: 16px;}
.fs18px {font-size: 18px;}
.fs20px {font-size: 20px;}
.fs22px {font-size: 22px;}
.fs24px {font-size: 24px;}
.fs26px {font-size: 26px;}
.fs28px {font-size: 28px;}
.fs30px {font-size: 30px;}
.fs32px {font-size: 32px;}
.fs34px {font-size: 34px;}
.fs36px {font-size: 36px;}
.fs38px {font-size: 38px;}
.fs40px {font-size: 40px;}
.fs42px {font-size: 42px;}
.fs44px {font-size: 44px;}
.fs46px {font-size: 46px;}
.fs48px {font-size: 48px;}
.fs50px {font-size: 50px;}
.fs52px {font-size: 52px;}
.fs54px {font-size: 54px;}
.fs56px {font-size: 56px;}

.lh14 { line-height: 1.4; }
.lh14_5 { line-height: 1.45; }
.lh15 { line-height: 1.5; }
.lh15_5 { line-height: 1.55; }
.lh16 { line-height: 1.6; }
</style>

<div id="campaign_special">
	<?php $this->load->view('page/campaign_redi_pc'); ?>
	<?php $this->load->view('page/campaign_redi_mobile'); ?>
</div>