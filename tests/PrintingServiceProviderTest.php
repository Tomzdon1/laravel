<?php

use App\Connectors\Exception;

/**
 * Description of PrintOutServiceProviderTest
 * Test usługi PrintOut.
 * @author roznowski
 */
class PrintingServiceProviderTest extends TestCase {
    
    
    public function testWorkingService(){
        
        $this->app->register(App\Providers\PrintingServiceProvider::class);
        $file = file_get_contents(__DIR__."/rawTestData/PrintOut/dane.xml");
        
        /* @var $printer Tue\Printing\Printer */
        $printer = $this->app->make('Printer'); 
        
        
        $doc = $printer->getDocument('TESTCOM', $file);
        
        
        \Log::debug('pdf->isError='.$doc->IsError());
        \Log::debug('pdf->isError='.$doc->IsError());
        
        $this->assertEquals($doc->ContentType(),Tue\Printing\FileType::PDF,"Wygenerowany plik nie jest PDF");        
        $this->assertFalse($doc->IsError(),"Błąd podczas generowania PDF".$doc->ErrorMsg());
        
    }
}
