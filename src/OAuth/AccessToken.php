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

class AccessToken {
    /**
     * Token key
     * @var type string
     */
    private $key;

    /**
     * Token secret
     * @var type string
     */
    private $secret;

    /**
     * 
     * @param string $key Token key
     * @param string $secret Token secret
     */
    public function __construct($key, $secret) {
        $this->key = $key;
        $this->secret = $secret;
    }
    
    /**
     * Get the token key
     * 
     * @return Token key
     */
    public function getKey() {
        return $this->key;
    }
    
    /**
     * Get the token secret
     * 
     * @return Token secret
     */
    public function getSecret() {
        return $this->secret;
    }
    
    public static function fromArray(array $config) {
        return new AccessToken($config["key"], $config["secret"]);
    }
}
