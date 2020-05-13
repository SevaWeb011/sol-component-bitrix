<?php
abstract class Table

{
    protected string $pathTable;
    protected PHPExcel $excel;
    private PHPExcel_Worksheet $sheet;
    protected string $pathSource;
    protected array $tableRaw;
    protected array $tableMap;

    public function __construct(string $pathTable, string $pathSource)
    {
        $this->pathTable = $pathTable;
        $this->pathSource = $pathSource;
        $this->excel = PHPExcel_IOFactory::load($pathTable);
        $this->sheet = $this->excel->getActiveSheet();
        $this->_setTableRaw();
        $this->map = new TableMap($this->tableRaw);
    }

    private function _setTableRaw():void
    {
        $tableRaw = [];
        $tableCells = $this->_getTableCells();

        for($i = 0; $i < count($tableCells); $i++){
            $cellName = $tableCells[$i];
            $tableRaw[$cellName] = $this->sheet->getCell($cellName)
                                               ->getValue();
        }

        $this->tableRaw = $tableRaw;
    }

    private function _getTableCells():array
    {
        try{
            $tableRaw = $this->sheet->getCellCollection();

            if(empty($tableRaw)) 
                throw new Exception("empty table Row");
        return $tableRaw;
        }
        catch(Exception $e){
            $error = json_encode(["error" => "Загруженная таблица не содержит элементов"]);
            echo $error;
            exit;
        }
    }

    

}
?>