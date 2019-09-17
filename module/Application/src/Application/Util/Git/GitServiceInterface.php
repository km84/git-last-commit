<?php

namespace Application\Util\Git;

interface GitServiceInterface {

    public function getLastCommit(string $repository = null, string $branch = null);

    public function setRepository(string $repository);

    public function getRepository();

    public function setBranch(string $branch);

    public function getBranch();

    public function setApiUri(string $branch);

    public function getApiUri();
}
