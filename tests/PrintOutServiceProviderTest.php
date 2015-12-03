<?php

use App\Connectors\Exception;

/**
 * Description of PrintOutServiceProviderTest
 * Test usługi PrintOut.
 * @author roznowski
 */
class PrintOutServiceProviderTest extends TestCase {
    
    
    public function testWorkingService(){
        
        $this->app->register(App\Providers\PrintOutServiceProvider::class);
        $file = file_get_contents(__DIR__."/rawTestData/PrintOut/dane.xml");
        
        /* @var $printout App\Connectors\PrintOut_Connector */
        $printout = $this->app->make('PrintOut');      
        $pdf = $printout->PrintSingleFile('TESTCOM',$file);
        
        \Log::debug('pdf->isError='.$pdf->IsError());
        \Log::debug('pdf->isError='.$pdf->IsError());
        
        $this->assertEquals($pdf->ContentType(),"application/pdf","Wygenerowany plik nie jest PDF");        
        $this->assertFalse($pdf->IsError(),"Błąd podczas generowania PDF".$pdf->ErrorMsg());
        
    }
}
