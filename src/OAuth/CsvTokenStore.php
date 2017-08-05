<?php

/* 
 * The MIT License
 *
 * Copyright 2017 falmeida.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Falmeida\QuickBooksOnline\OAuth;

class CsvTokenStore extends CachedTokenStore {
 
    const DEFAULT_CSV_CONFIG = [
        "delimiter" => ",",
        "enclosure" => '"',
        "escape" => "\\"
    ];
    
    private $filepath;
    
    private $tokenIdFromArrayFn;
    
    private $tokenFromArrayFn;
    
    private $arrayFromTokenFn;
    
    private $csvConfig;
    /**
     * Constructor
     * 
     * @param type $filepath
     * @param type $tokenFromArrayFn
     * @param type $arrayFromTokenFn
     * @param type $csvConfig
     */
    public function __construct(
            $filepath,
            $tokenFromArrayFn,
            $arrayFromTokenFn,
            $csvConfig = self::DEFAULT_CSV_CONFIG)
    {
        parent::__construct();
        
        $this->filepath = $filepath;
        $this->tokenIdFromArrayFn = function($data) { return $data[0]; };
        $this->tokenFromArrayFn= $tokenFromArrayFn;
        $this->arrayFromTokenFn = $arrayFromTokenFn;
        $this->csvConfig = $csvConfig;
        
        $this->tokens = $this->loadTokens();
    }
    
    protected function loadTokens() {
        $tokens = [];
        
        if (!file_exists($this->filepath)) {
            return $tokens;
        }
        
        $handle = fopen($this->filepath, "r");
        while (($data = fgetcsv($handle, 
                                1000, 
                                $this->csvConfig["delimiter"],
                                $this->csvConfig["enclosure"],
                                $this->csvConfig["escape"])) !== FALSE) {

            
            $id = ($this->tokenIdFromArrayFn)($data);
            $token = ($this->tokenFromArrayFn)($data);
            
            
            
            $tokens[$id] = $token;
        }
        fclose($handle);    
        
        return $tokens;
    }
    
    private function save() {
        $handle = fopen($this->filepath, "w");
        $tokens = $this->getAll();
        foreach($tokens as $id => $accessToken) {
        	$fields = ($this->arrayFromTokenFn)($accessToken);
        	array_unshift($fields, $id);

		fputcsv($handle, 
			$fields,
			$this->csvConfig["delimiter"],
			$this->csvConfig["enclosure"],
			$this->csvConfig["escape"]);
        }
        fclose($handle);
    }
    
    protected function tokenReplaced($id, $accessToken) {
         $this->save();
    }
    
    protected function tokenRegistered($id, $accessToken) {
        $handle = fopen($this->filepath, "a+");
        
        $fields = ($this->arrayFromTokenFn)($accessToken);
        array_unshift($fields, $id);
        
        fputcsv($handle,
                $fields,
                $this->csvConfig["delimiter"],
                $this->csvConfig["enclosure"].
                $this->csvConfig["escape"]);
        
        fclose($handle);
    }
    
    protected function tokenRemoved($id) {
        $this->save();
    }
    
    
}
