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

namespace Falmeida\QuickBooksOnline;

use QuickBooksOnline\API\Utility\Configuration\ConfigurationManager;
use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\Core\CoreConstants;
use QuickBooksOnline\API\PlatformService\PlatformService;


class OAuthManager {
    /**
     *
     * @var string Store to cache the OAuth configuration data
     */
    private $store;
    
    public function __construct($store = null) {
        $this->store = $store 
    }
    
    public function disconnect(array $credentials) {
        
    }
    
    public function refresh(array $credential) {
        
    }
    
    public function save($application, $credentials) {
        
    }
    
    public function remove(Application $application, $credentials) {
        
    }
    
    
    
}