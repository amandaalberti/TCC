<?php

use Illuminate\Database\Seeder;

class PalavrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	try {
	    	$handle = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'palavras.sql', "r");

	    	while(($sql = fgets($handle)) !== false)
	        	DB::unprepared(DB::raw($sql));
	    } finally {
	    	if(isset($handle))
	    		fclose($handle);
	    }
    }
}
