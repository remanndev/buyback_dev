<?php
  // Site defaults
  $site_name = $this->config->item('website_name', 'tank_auth');
  $site_keyword = $this->config->item('website_meta_keywords', 'tank_auth');
  $site_description = $this->config->item('website_meta_description', 'tank_auth');
  $site_share_image = $this->config->item('website_share_image', 'tank_auth');
  if (!$site_share_image) {
    $site_share_image = $this->config->item('website_logo_src', 'tank_auth');
  }

  // Meta defaults
  $meta = new stdClass();

  $meta->site_name = $site_name;
  $meta->title = isset($arr_meta->title) ? $arr_meta->title : $site_name;
  //$meta->title = isset($arr_meta->title) ? $arr_meta->title .' | '.$site_name : $site_name;
  //$meta->title = isset($arr_meta->title) ? $site_name .' | '. $arr_meta->title : $site_name;
  $meta->keywords = isset($arr_meta->keywords) ? $arr_meta->keywords : $site_keyword;
  $meta->description = isset($arr_meta->description) ? $arr_meta->description : $site_description;

  $meta->og_locale = isset($arr_meta->og_locale) ? $arr_meta->og_locale : 'ko_KR';
  $meta->og_type = isset($arr_meta->og_type) ? $arr_meta->og_type : 'website';
  $meta->og_title = isset($arr_meta->og_title) ? $arr_meta->og_title .' | '.$site_name : $this->config->item('website_meta_og_title', 'tank_auth');
  $meta->og_description = isset($arr_meta->og_description) ? $arr_meta->og_description : $this->config->item('website_meta_og_description', 'tank_auth');
  $meta->og_url = isset($arr_meta->og_url) ? $arr_meta->og_url : current_url();
  $meta->og_site_name = isset($arr_meta->og_site_name) ? $arr_meta->og_site_name : $this->config->item('website_meta_og_site_name', 'tank_auth');
  $meta->og_image = isset($arr_meta->og_image) ? $arr_meta->og_image : $site_share_image;
  if (!isset($arr_meta->og_image) && isset($partner['logo_src']) && $partner['logo_src']) {
    $meta->og_image = $partner['logo_src'];
  }

  // View defaults
  $favicon_url = $this->config->item('website_favicon', 'tank_auth');
  $header_view = ( isset($header_view) && $header_view ) ? $header_view : 'layout/inc_header_view';
  $footer_view = ( isset($footer_view) && $footer_view ) ? $footer_view : 'layout/inc_footer_view';
  $header_data = isset($header_data) && is_array($header_data) ? $header_data : array();
  $footer_data = isset($footer_data) && is_array($footer_data) ? $footer_data : array();
  $header_payload = array_merge((array)$meta, $header_data);
  $footer_payload = array_merge((array)$meta, $footer_data);
?><!doctype html>
<html class="no-js" lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?php echo $meta->title ?></title>
  <meta name="title" content="<?php echo $meta->title ?>">
  <meta name="keywords" content="<?php echo $meta->keywords ?>">
  <meta name="description" content="<?php echo $meta->description ?>">
  <meta property="og:locale" content="<?php echo $meta->og_locale ?>" />
  <meta property="og:type" content="<?php echo $meta->og_type ?>"/>
  <meta property="og:title" content="<?php echo $meta->og_title ?>"/>
  <meta property="og:description" content="<?php echo $meta->og_description ?>"/>
  <meta property="og:url" content="<?php echo $meta->og_url ?>"/>
  <meta property="og:image" content="<?php echo $meta->og_image ?>"/>

  <link rel="canonical" href="<?php echo $meta->og_url ?>" />
  <link rel="shortcut icon" href="<?php echo base_url('favicon.ico?v=2603') ?>" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url('favicon.ico?v=2603') ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo CSS_DIR ?>/base.css">

  <?php
  // Extra CSS stack
  if(isset($GLOBALS['hoksi_css']) && $GLOBALS['hoksi_css']) { foreach($GLOBALS['hoksi_css'] as $css_file) { echo $css_file . PHP_EOL;}}
  /*
  load_css('<link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/blitzer/jquery-ui.css" />');
  */
  ?>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Sans+KR:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#0f49bd",
            "background-light": "#f6f6f8",
            "background-dark": "#101622",
          },
          fontFamily: {
            "display": ["Inter", "Noto Sans KR", "sans-serif"],
            "sans": ["Inter", "Noto Sans KR", "sans-serif"],
          },
          borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
        },
      },
    }
  </script>
  <style>
    body {
      font-family: 'Inter', 'Noto Sans KR', sans-serif;
    }
    .step-active {
      @apply border-primary text-primary;
    }
    .step-completed {
      @apply border-primary bg-primary text-white;
    }
    .step-inactive {
      @apply border-gray-300 text-gray-400;
    }
    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 4px;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body class="bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-100 min-h-screen flex flex-col font-display">
  <?php $content_payload = array_merge((array)$meta, isset($content_data) && is_array($content_data) ? $content_data : array()); ?>
  <?php $this->load->view($header_view, $header_payload); ?>
  <?php if ( isset($viewPage) && $viewPage ) $this->load->view($viewPage, $content_payload); // content view ?>
  <?php $this->load->view($footer_view, $footer_payload); ?>

  <script src="<?php echo JS_DIR ?>/common.js?v=<?php //echo rand() ?>"></script>
  <script src="<?php echo JS_DIR ?>/layout.js?v=12<?php //echo rand() ?>"></script>
  <?php
  // Extra script stack
  if(isset($GLOBALS['hoksi_js']) && $GLOBALS['hoksi_js']) { foreach($GLOBALS['hoksi_js'] as $js_file) { echo $js_file . PHP_EOL;}}
  /*
  load_js('<script src="/js/plugins/jqgrid/4.6.0/jquery.jqGrid.min.js" type="text/javascript"></script>');
  */
  ?>

  <?php
  // Popup output
  if(! $this->uri->segment(1)) {

    // Layer popups
    foreach ($pulayer as $o):
      echo $o;
    endforeach;

    // Basic popups
    if ($pubasic):
  ?>
      <script type='text/javascript'>
      //<![CDATA[
      $(function() {
        <?php foreach ($pubasic as $o): ?>
        var popup<?php echo $o->id?> = <?php echo $o->html?>
        <?php endforeach; ?>
      });
      //]]>
      </script>
  <?php
    endif;
  }
  ?>

</body>
</html>
