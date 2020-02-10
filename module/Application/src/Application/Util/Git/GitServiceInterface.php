<?php

namespace Application\Util\Git;

interface GitServiceInterface {

    public function setRepository(string $repository);

    public function getRepository();

    public function setBranch(string $branch);

    public function getBranch();

    public function setApiUri(string $uri);

    public function getApiUri();
    
    public function getDefaultApiUri();
}
