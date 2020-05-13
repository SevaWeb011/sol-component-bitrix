<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$ruleList = [
	"Документы принимаются в форматах: *xls и *xlsx.",
	"В документе должны присутствовать все обязательные поля -<a download href = \"/upload/tableImport/sample.xlsx\"> скачать шаблон </a>",
	"Если поле \"Оценочная стоимость\" заполнено, необходимо также заполнить поле \"Штрихкод\"",
	"Поле \"Цена\" обязательно для заполнения во всей таблице."
	]
?>
<h1>Загрузка файла</h1>
<br />
<form id = "send-excel" enctype="multipart/form-data" method="POST">
  <div class="form-group">
	<input type="file" name ="file"class="form-control-file" id="file">
	<input type="hidden" name = "text" value = "2"/>
	<br />
	<input type="submit" onclick = "sendExcell(event)" value="Начать загрузку" class="btn btn-success" style = "font-size: 1.5em"/>
	<label class="error" id = "error"	visibility= "hiddenid" > </label>
  </div>
</form>
<br />
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Правила загрузки:</h4>
<?foreach($ruleList as $rule):?>
  <hr>
  <p class="rules"><?=$rule?></p>
<?endforeach;?>

</div>
<br>
<table class="tableProduct table" id = "tableProduct">
  <thead id = "tableProductHead">
	
  </thead>
  <tbody id = "tableProductBody">

  </tbody>
</table>