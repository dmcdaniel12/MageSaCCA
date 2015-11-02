<?php

// This will Parse a CSV file into an array

class Csv {
    
    public function parseCsv($file){
        return array_map('str_getcsv', file($file));
    }
    
}
