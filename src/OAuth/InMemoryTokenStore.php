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

class InMemoryTokenStore extends TokenStore {
     
    /**
     * Tokens
     * @var array
     */
    protected $tokens;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tokens = [];
    }
    
    /**
     * Get all tokens stored in this store
     * 
     * @return Array with all tokens stored in this store
     */
    public function getAll() {
        return array_values($this->tokens);
    }
    
    /**
     * Get token by it's unique identifier
     *
     * @return AccessToken
     */
    public function getById($id) {
        return array_key_exists($id, $this->tokens) ? $this->tokens[$id] : null;
    }
    
    /**
     * 
     * @param mixed $id Identifier of the token to remove
     */
    public function remove($id) {
        if (!array_key_exists($id, $this->tokens)) {
            throw new \Exception("No token is registered with the given identifier");
        }
        
        unset($this->tokens[$id]);
    }
    
    /**
     * Register a new token in the store with the given identifier
     */
    public function register($id, $accessToken) {
        if (array_key_exists($id, $this->tokens)) {
            throw new \Exception("Id is already registered");
        }
        
        $this->tokens[$id] = $accessToken;
    }
    
}