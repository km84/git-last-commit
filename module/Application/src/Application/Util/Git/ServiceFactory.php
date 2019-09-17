<?php

namespace Application\Util\Git;

use Zend\Http\Client as HttpClient;

/**
 * Tworzy prostego klienta do obsługi wybranego hostingu gita. 
 */
class ServiceFactory implements AbstractFactoryInterface {

    public function createServiceWithName(string $service): GitServiceInterface {
        $service = ucfirst($service);
        if (class_exists("Application\\Util\\Git\\Service\\{$service}")) {
            $className = "Application\\Util\\Git\\Service\\{$service}";
            $client = new HttpClient();
            $gitService = new $className($client);
            $gitService->setApiUri('https://api.github.com'); // default API
            return $gitService;
        }
        throw new Exception\ServiceNotFoundException(sprintf('Unknown service "%s"', $service));
    }

}
