<?php

namespace Application\Util\Git\Service;

use Application\Util\Git\GitServiceInterface;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;

class Github implements GitServiceInterface {

    private $repository;
    private $branch;

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

    public function getLastCommit(string $repository = null, string $branch = null) {
        if (!isset($repository)) {
            $repository = $this->getRepository();
        }
        if (!isset($branch)) {
            $branch = $this->getBranch();
        }
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));
        $uri = ' api.github.com/repos/ezimuel/zend-expressive-api/commits/master'; 
        $request->setUri($uri);
        $request->setMethod('GET');
        //$request->setPost(new Parameters(array('someparam' = > $somevalue)));

        $client = new Client();
        $response = $client->dispatch($request);
        $data = json_decode($response->getBody(), true);
        return $data['sha'];
        return "Testowy hash";
    }

}
