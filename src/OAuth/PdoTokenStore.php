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

class PdoTokenStore extends CachedTokenStore {
    
    /**
     * 
     * @param \PDO $pdo
     * @param type $tokenIdFromArrayFn
     * @param type $tokenFromArrayFn
     * @param type $arrayFromTokenFn
     * @param type $tableMetadata
     * @param type $tableNamePrefix
     */
    public function __construct(
            \PDO $pdo,
            $tokenIdFromArrayFn,
            $tokenFromArrayFn,
            $arrayFromTokenFn,
            $tableName = "tokens",
            $columnIdName = "id",
            $columnIdType= PDO::PARAM_STR) {
        parent::construct();
        
        $this->pdo = $pdo;
        $this->tokenIdFromArrayFn = $tokenIdFromArrayFn;
        $this->tokenFromArrayFn = $tokenFromArrayFn;
        $this->arrayFromTokenFn = $arrayFromTokenFn;
        $this->tableName = $tableName;   
        $this->columnIdName = $columnIdName;
        $this->columnIdType = $columnIdType;
        
        $this->tokens = $this->loadTokens();
    }
    
    private function getTableName() {
        return $this->tableName;       
    }
    
    private function getColumnIdName() {
        return $this->columnIdName;
    }
    
        
    private function getColumnIdType() {
        return $this->columnIdType;
    }
    /**
     * 
     * @return array
     */
    protected function loadTokens() {
        $tokens = [];

        $query = implode(" ", ["SELECT * FROM ", $this->getTableName()]);
        
        $pdoStmt = $this->pdo->prepare($query);
        $dbRecords= $pdoStmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($dbRecords as $fields) {
            $token = ($this->tokenFromArrayFn)($fields);
            array_push($tokens, $token);
        }
        
        return $tokens;
    }
    
    protected function tokenRegistered($id, $accessToken) {        
        $tokenArray = ($this->arrayFromTokenFn)($accessToken);
        
        $fieldNames = array_keys($tokenArray);
        array_push($fieldNames, $this->getColumnIdName());
        $fieldNamesList = "(" . implode(",", $fieldNames) . ")";
        
        $tokenArray[$this->getColumnIdName()] = $id;
        $fieldValuesList = "(:" . implode(",:", $tokenArray) . ")";
        
        $query = implode(" ", ["INSERT INTO",
                               $this->getTableName(),
                               $fieldNamesList,
                               "VALUES",
                               $fieldValuesList]);
        $stmt = $this->pdo->prepare($query);
        
        foreach($fieldNames as $fieldName) {
            $paramType = $fieldName == $this->getColumnIdName()
                            ? $this->getColumnIdType()
                            : \PDO::PARAM_STR;

            $stmt->bindValue(":" . $fieldName, $tokenArray[$fieldName], $paramType);
        }
        
        if (!$stmt->execute()) {
            throw new \Exception("Could not register token with id " . $id . " the DB");
        }
    }
    
    protected function tokenRemoved($id) {        
        $query = implode(" ", ["DELETE FROM", 
                               $this->getTableName(), 
                               "WHERE",
                               $this->getColumnIdName(),
                               "= ?"]);
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(1, $id, $this->getColumnIdType());
        
        if (!$stmt->execute()) {
            throw new \Exception("Could not remove token with id " . $id . " from the DB");
        }
    }
  
}