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

abstract class CachedTokenStore extends InMemoryTokenStore {

    /**
     * Constructor
     * 
     * @param type $filepath
     * @param type $tokenIdFromArrayFn
     * @param type $tokenFromArrayFn
     * @param type $arrayFromTokenFn
     * @param type $csvConfig
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    
    abstract protected function tokenRegistered($id, $accessToken);
    
    abstract protected function tokenRemoved($id);
    
    /**
     * Remove a token with a given identifier from the store
     * 
     * @param mixed $id Identifier of the token to remove
     */
    public function remove($id) {
        parent::remove($id);
        
        $this->tokenRemoved($id);
    }
    
    /**
     * Register a new token in the store with the given identifier
     * 
     * @param mixed $id Token identifier
     * @param AccessToken $accessToken Access token object
     */
    public function register($id, $accessToken) {
        $existingToken = $this->getById($id);
        
        parent::register($id, $accessToken);
        
        if ($existingToken) {
            $this->tokenReplaced($id, $accessToken);
        } else {
            $this->tokenRegistered($id, $accessToken);
        }        
    }
}
