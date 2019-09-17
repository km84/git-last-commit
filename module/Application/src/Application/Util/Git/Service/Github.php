<?php

namespace Application\Util\Git\Service;

use Application\Util\Git\GitServiceInterface;
use Application\Util\Git\Exception\BadArgumentsException;
use Zend\Http\Request;
use Zend\Http\Client;

class Github implements GitServiceInterface {

    private $repository;
    private $branch;
    private $apiUri;
    private $httpClient;

    public function __construct($httpClient) {
        $this->httpClient = $httpClient;
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

    public function getApiUri() {
        return $this->apiUri;
    }

    public function setApiUri(string $branch) {
        $this->apiUri = $branch;
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

        $this->httpClient->setAdapter('Zend\Http\Client\Adapter\Curl');
        $this->httpClient->setUri($this->getURI());
        $this->httpClient->setMethod('GET');
        $response = $this->httpClient->send();
        if (!$response->isSuccess()) {
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
            return $message;
        }
        $body = $response->getBody();
        $json = json_decode($body, true);
        if (!isset($json['sha'])) {
            throw new BadResponseDataException(sprintf('Response element "%s" not found', 'sha'));
        }
        return $json['sha'];
    }

    private function getURI() {
        $branch = $this->getBranch();
        $repository = $this->getRepository();
        $apiUri = $this->getApiUri();
        if (empty($branch) || empty($repository) || empty($apiUri)) {
            throw new BadArgumentsException('Missing argument.');
        } elseif (false === strpos($repository, '/')) {
            throw new BadArgumentsException('Unrecognize repository name.');
        }
        list ($owner, $repo) = explode('/', $repository);

        return sprintf('%s/repos/%s/%s/commits/%s', $apiUri, $owner, $repo, $branch);
    }

}
