<?php

namespace Tue\Calculating;

abstract class calculateExcel{
	
	private $objPHPExcel; //obiekt PHPexcel
	protected $params; //tablica parametrow 
	protected $calculatedRange; // obszar do zwrócenia danych z excela

        public $excelFilePath; //sciezka do excela

	public function __construct($excelFilePath){
		$this->excelFilePath = $excelFilePath;
		//$this->params = $params;
		//$this->validateParams();
		$this->createPHPExcelObject();
		$this->setCalculatedRange();
	}
	
	private function createPHPExcelObject(){
		$objReader = new \PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(true);
		try {
			$this->objPHPExcel = $objReader->load($this->excelFilePath);
		} catch(PHPExcel_Reader_Exception $e) {
			die('Error loading file: '.$e->getMessage());
		}
		//$this->objPHPExcel = PHPExcel_IOFactory::load($this->excelFilePath);
	}
	
	private function setParamsInExcelObject(){
		$maxRow = $this->objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		for($i = 1; $i <= $maxRow; $i++) { // lecimy po wszystkich parametrach z excela z kolumny A
			$paramName = $this->objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
			if(array_key_exists($paramName,$this->params)){ // nadmiarowe parametry zostaną zignorowane
				$arrVal = $this->params[$paramName];
				if(is_array($arrVal)){ //jeśli parametr jest tablicą to jego wartości wrzucamy w poziomie
					$this->objPHPExcel->setActiveSheetIndex(0)->fromArray($arrVal, null, 'B'.$i);
					//$col = 'B';
					//foreach($arrVal as $val){
					//	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$i, $val);
					//	$col++;
					//}
				}else{
					$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $arrVal);
				}
				
			}
		}
	}
	
	public function getCalculatedValues($params){
	
		$this->params = $params;
		$this->setParamsInExcelObject();
		
		$dataFromExcel = $this->objPHPExcel->setActiveSheetIndex(1)->toArray(null,true,false,false); //pobranie całego zakresu z excela
		
		$retArray = [];
		$size = count($dataFromExcel);
		$titles = $dataFromExcel[0];
		$length = count($titles);
		$badIndexes = [];
		
		if($this->calculatedRange === null || $this->calculatedRange === []){ // nie ograniczamy zwracanego zakresu
			for($i = 1; $i < $size; $i++){ //przerobienie na tablice asocjacyjną
				$retArray[] = array_combine($dataFromExcel[0], $dataFromExcel[$i]);
			}
		}else{ // zwracamy konkretne kolumny
			for($j = 0; $j < $length; $j++){
				if(!in_array($titles[$j],$this->calculatedRange)){
					$badIndexes[] = $j;
				}
			}
			for($i = 1; $i < $size; $i++){ //przerobienie na tablice asocjacyjną
				foreach ($badIndexes as $index){
					unset($dataFromExcel[$i][$index]);
				}
				$dataFromExcel[$i] = array_values($dataFromExcel[$i]);
				$retArray[] = array_combine($this->calculatedRange, $dataFromExcel[$i]);
			}
		}
		
		return $retArray;
	}
	
	abstract protected function validateParams(); // wymaga definicji w podklasie
		
	abstract protected function setCalculatedRange(); // wymaga definicji w podklasie

}