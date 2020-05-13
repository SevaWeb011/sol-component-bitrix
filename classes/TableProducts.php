<?php
//getColumnDimension(a, create)
//getHighestColumn - самая правая колонка
//getHighestRow - самая нижняя строка
//getCellCollection - coordinats
//getCell("A1", create) =>
    //getValue()
    //getFormattedValue()

class TableProducts extends Table{

    private array $titles;
    private array $rulesTable;

    public function __construct(string $pathTable, string $pathSource){
        parent::__construct($pathTable, $pathSource);
        $this->titles = [ //TODO: import in Bitrix
            "id" => "Идентификатор",
            "name" =>"Название товара",
            "price" => "Цена",
            "code" => "Штрихкод",
            "assessed_price" =>"Оценочная стоимость"
        ];

        $this->rulesTable = [ // key depends on the value (TODO: import in bitrix)
            "price" => "*",
            "code" => "assessed_price"
        ];
     
    }

    public function get():TableMap
    {
        try{
            if(!($this->_isValidTable()))
                throw new Exception("The table does not match the pattern.");
        return $this->map;
        }
        catch(Exception $e){
            $this->_throwError(["error" => "Таблица не соотвествует шаблону"]);
        }
    }

    public function generateSampleTable():void
    {
        $table = new PHPExcel();
        $sheet  = $table->getActiveSheet();
        $titles = array_values($this->titles);

        $sheet->fromArray($titles);
        $file = PHPExcel_IOFactory::createWriter($table, 'Excel2007');
        $file->save($this->pathSource . "/sample.xlsx");
        //var_dump($doc);
    }

    private function _isValidTable():bool
    {
        try{
            $isValid = true;
            $table = $this->map->get();
            $columns = $this->map->getCountColumn();
            $isValid = $this->_isValidColumn($columns) && $this->_isValidTitles($table);

            if($isValid){
                $isValid = $this->_isValidCells($table);
                if(!$isValid)
                    throw new Exception("Rules were violated when filling out the table");
            }
        }
        catch(Exception $e){
            $this->_throwError(["error" => "Заполнены не все обязательные или связанные поля"]);
        }
        return $isValid;

    }

    private function _isValidColumn(int $columns):bool
    {
        return $columns === count($this->titles) ? true : false;
    }

    private function _isValidTitles(array $table):bool
    {
        foreach($table as $title=>$column){
            if (!in_array($title, $this->titles))
                return false;
        }
        return true;
    }

    private function _isValidCells(array $table):bool
    {

            $tableWithCode = $this->_replaceTitleToCode($table);
            
            foreach($this->rulesTable as $field=>$rule){
                if($rule === "*"){
                    if(!$this->_isValuesExist($tableWithCode[$field]))
                        return false;
                }
                elseif(!empty($tableWithCode[$rule]) && !empty($tableWithCode[$field])){
                    if(!$this->_isRelatedFields($field, $rule, $tableWithCode))
                        return false;
                }
                else throw new Exception("Error validation product table");
            }
            return true;
    }

    private function _replaceTitleToCode(array $table):array
    {
        $tableWithCode = [];
        $codes = array_flip($this->titles);

        foreach($table as $title=>$column){
            $code = $codes[$title];
            $tableWithCode[$code] = $column;
        }

        return $tableWithCode;
    }

    private function _isValuesExist($column):bool
    {
        return !in_array(null, $column) ? true : false;
    }

    private function _isRelatedFields($field, $rule, $tableWithCode):bool
    {
        foreach($tableWithCode[$rule] as $key=>$cellValue){
            if(!empty($cellValue))
                if(empty($tableWithCode[$field][$key]))
                    return false;
        }
        return true;
    }

    private function _throwError(array $error):void
    {
        echo json_encode($error);
        exit;
    }
}
?>