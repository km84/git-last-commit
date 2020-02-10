<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Util\Git\Service;

/**
 * Description of AbstractService
 *
 * @author echo
 */
class AbstractService {
    
    protected $repository;
    protected $branch;
    protected $apiUri;
    protected $httpClient;
    
    
    public function __construct($httpClient) {
        $this->httpClient = $httpClient;
        $this->setApiUri($this->getDefaultApiUri());
    }

    public function setRepository(string $repository) {
        $this->repository = $repository;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setBranch(string $branch) {
        $this->branch = $branch;
    }
    
    public function getBranch() {
        return $this->branch;
    }
    
    public function getApiUri() {
        return $this->apiUri;
    }

    public function setApiUri(string $uri) {
        $this->apiUri = $uri;
    }
}
