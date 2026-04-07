<!-- <div class="breadcrumb">
	<span>HOME</span> <i class="ionicons ion-ios-arrow-right"></i> 공급사관리
	<i class="ionicons ion-ios-arrow-right"></i> 공급사 신청목록
</div> -->


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>admin">HOME</a></li>
	<?php if( isset($breadcrumb) ) { ?>
	<?php foreach($breadcrumb as $menu => $url) { ?>
	<li class="breadcrumb-item"><?php echo ('' != $url) ? '<a href="'.$url.'">'.$menu.'</a>' : $menu; ?></li>
	<?php } ?>
	<?php } ?>
  </ol>
</nav>
