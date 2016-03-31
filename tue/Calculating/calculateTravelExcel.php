<?php

namespace Tue\Calculating;

class calculateTravelExcel extends calculateExcel {
	
	protected function validateParams(){

	}
	
	protected function setCalculatedRange(){
		$this->calculatedRange = ['WARIANT','SKLADKA','NETTO']; // zwracane kolumny
	}
	
}