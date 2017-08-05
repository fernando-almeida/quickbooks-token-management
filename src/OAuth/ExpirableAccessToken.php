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

class ExpirableAccessToken extends AccessToken {
    /**
     * @see https://developer.intuit.com/docs/0100_quickbooks_online/0100_essentials/000500_authentication_and_authorization/connect_from_within_your_app#/Managing_OAuth_access_tokens
     */
    const TOKEN_EXPIRATION_DURATION = 15552000; // 180 days = 180 * 24 * 60 * 60 (seconds) = 15552000 seconds 
    const TOKEN_REFRESH_WINDOW_MIN = 13046400; // 151 days = 13046400 seconds
    const TOKEN_REFRESH_WINDOW_MAX = 15465600; // 179 days = 15465600 seconds
    
    public static function init() {
        
    }
    
    /**
     * Creation timestamp
     * 
     * @var integer Creation timestamp 
     */
    private $creationTimestamp;
    
    public function __construct($key, $secret, $creationTimestamp = null) {
        parent::__construct($key, $secret);
        $this->creationTimestamp = $creationTimestamp ?: time();
    }
    
    public function getCreationTimestamp() {
        return $this->creationTimestamp;
    }
    
    public function getExpirationTimestamp() {
        return $this->creationTimestamp + self::TOKEN_EXPIRATION_DURATION;
    }
    
    public function getMinRefreshTimeTime() {
        return $this->creationTimestamp + self::TOKEN_REFRESH_WINDOW_MIN;
    }
    
    public function getMaxRefreshTimeTime() {
        return $this->creationTimestamp + self::TOKEN_REFRESH_WINDOW_MIN;
    }
    
    /**
     * Check if a token has expired
     * @return type
     */
    public function hasExpired() {
        return $this->getExpirationTime() > time();
    }
    
    /**
     * Check if a token can be refreshed
     * 
     * @return boolean
     * @throws \Exception
     */
    public function isRefreshable() {        
        return $this->getExpirationTime() < $this->getMaxRefreshTimeTime();
    }
    
    /**
     * Check if a token can be refreshed now
     * 
     * @return boolean
     * @throws \Exception
     */
    public function canRefreshNow() {
        return $this->timeUntilRefresh() == 0;
    }
    
    /**
     * Get the remaining time until refresh
     * 
     * @return boolean
     * @throws \Exception
     */
    public function timeUntilRefresh() {
        if (!isRefreshable()) {
            throw new \Exception("Token is no longer refreshable");
        }
        
        return min(0, $this->getMinRefreshTimeTime() - time());
    }
    
    public static function fromArray(array $config) {
        return new ExpirableAccessToken(
                $config["key"], 
                $config["secret"],
                array_key_exists("creationTimestamp", $config) ? $config["creationTimestamp"] : null);
    }
    
}