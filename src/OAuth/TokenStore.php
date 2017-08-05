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

abstract class TokenStore {
    
    /**
     * Retrieve tokens that match a given predicate
     * 
     * @param callable $tokenPredicateFn Boolean predicate to be matched against each existing token
     * @return array Array with tokes matching the predicate
     */
    public function getFiltered(callable $tokenPredicateFn) {
        return array_filter($this->getTokens(), $tokenPredicateFn);
    }
    
    /**
     * Get all tokens stored in this store
     * 
     * @return Array with all tokens stored in this store
     */
    abstract public function getAll();
    
    /**
     * Get token by it's unique identifier
     *
     * @return AccessToken
     */
    abstract public function getById($id);
    
    /**
     * Remove a token from the datastore using its unique identifier
     *
     * @return AccessToken
     */
    abstract public function remove($id);
    
    /**
     * Register a new token in the store with the given identifier
     */
    abstract public function register($id, $accessToken);
}