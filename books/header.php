<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<? use Bitrix\Main\Page\Asset;
$APPLICATION->ShowHead();
Asset::getInstance()->addJs("http://code.jquery.com/jquery-1.8.3.js");
?>
<title><?$APPLICATION->ShowTitle()?></title>
<!--Import front-libs-->
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<div id="header"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.jpg" id="header_logo" height="105" alt="" width="508" border="0"/>
  <div id="header_text"><?$APPLICATION->IncludeFile(
			$APPLICATION->GetTemplatePath("include_areas/company_name.php"),
			Array(),
			Array("MODE"=>"html")
		);?> </div>

	<a href="/" title="Главная" id="company_logo"></a>

  <div id="header_menu"><?$APPLICATION->IncludeFile(
			$APPLICATION->GetTemplatePath("include_areas/header_icons.php"),
			Array(),
			Array("MODE"=>"php")
		);?> </div>

</div>

<div id="zebra"></div>
<div class = "content-sol">

    

      