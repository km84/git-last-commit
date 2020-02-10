<?php

namespace Application\Util\Git;

interface GitGetLastCommitInterface {

    public function getLastCommit(string $repository = null, string $branch = null);

}
