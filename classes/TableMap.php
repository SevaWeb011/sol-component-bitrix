<?php
class TableMap{
    private array $map;
    private array $table;
    private int $countColumn;
    private int $countRow;
    private string $firstCell;
    public function __construct($table)
    {
        $this->table = $table;
        $this->countRow = 0;
        $this->countColumn = 0;
        $this->firstCell = "";
        $this->_initMap($this->table);//TODO: isValidTable
    }

    public function get():array
    {
        return $this->map;
    }

    public function getCountColumn():int
    {
        return $this->countColumn;
    }

    public function getCountRow():int
    {
        return $this->countRow;
    }

    public function getFirstCell()
    {
        return $this->firstCell;
    }

    private function _setCountColumn(int $count):void
    {
        $this->countColumn = $count;
    }

    private function _initMap(array $table):void
    {
        $mapRaw = [];
        foreach($table as $cellName=>$val){
            if(empty($this->firstCell)){
                $this->_setFirstCell($cellName);
            }
            $letter = $this->_getLetterCell($cellName);
            $mapCells[$letter][] = $cellName;
        }
        //exit;
        //var_dump($map);
        $this-> _setCountRow($mapCells);
        $this-> _setCountColumn(count($mapCells));

        $this->_setMap($mapCells);
    }

    private function _setFirstCell(string $cellName):void
    {
        $this->firstCell = $cellName;
    }

    private function _getLetterCell(string $cellName):string
    {
        $match = [];
        $regExp = "/[a-zA-z]+/";
        preg_match($regExp, $cellName, $match);
        return !empty($match) ? $match[0]: "";
    }

    private function _setCountRow(array $mapCells):void
    {  
        $maxRows = 0;
        foreach($mapCells as $row){
            $count = count($row);
            if ($count > $maxRows)
                $maxRows = $count;
        } 
        $this->countRow = $count;
    }


    private function _setMap(array $map):void
    {
        foreach($map as $key=>$column){
            $map[$key]= $this->_replaceCellToValues($column);
        }
        $this->_replaceLetterToTitle($map);
        $this->map = $map;
    }

    private function _replaceCellToValues($column):array
    {
        $columnValues = [];
        $countCell = $this->countRow;
        $activeNumberRow =  $this->_getNumberCell($this->firstCell);

        for($cellActive = 0; $cellActive < $countCell; $cellActive++){

            if(empty($column[$cellActive])){
                $this->_addNullToCell($columnValues, 1);
                continue;
            }

            if(empty($column[$cellActive]))
                continue;
            $name = $column[$cellActive];
            
            $number = $this->_getNumberCell($name);

            if($activeNumberRow !== $number){
                $countReplace = $number - $activeNumberRow;
                $this->_addNullToCell($columnValues, $countReplace);
                $activeNumberRow = $number;
                $countCell -= $countReplace;
            }

            $columnValues[] = $this->table[$name];
            $activeNumberRow++;
        }
        return($columnValues);
    }

    private function _addNullToCell(array &$column, int $end):void
    {
        for($i = 0; $i < $end; $i++)
            $column[] = null;
    }

    private function _getNumberCell(string $cellName):int
    {
        $match = [];
        $regExp = "/[0-9]+/";
        preg_match($regExp, $cellName, $match);
        return !empty($match) ? $match[0]: 0;
    }


    private function _replaceLetterToTitle(array &$map):void
    {
        $mapWithTitles = [];
        foreach ($map as $letter=>$column){
            $title = !empty($column) ? $column[0] : "";
            unset($column[0]);
            $mapWithTitles[$title] = $column;
        }
        $map = $mapWithTitles;
    }
}
?>