<?php

namespace Application\Util\Git;

use Zend\Http\Client as HttpClient;

/**
 * Tworzy prostego klienta do obsługi wybranego hostingu gita. 
 */
class ServiceFactory implements AbstractFactoryInterface {

    public function createServiceWithName(string $serviceName): GitServiceInterface {
        $service = ucfirst($serviceName);
        if (class_exists("Application\\Util\\Git\\Service\\{$service}")) {
            $className = "Application\\Util\\Git\\Service\\{$service}";
            //@TODO jak pozbyć się tej zależności ?
            $client = new HttpClient();
            $gitService = new $className($client);
            return $gitService;
        }
        throw new Exception\ServiceNotFoundException(sprintf('Unknown service "%s"', $service));
    }

}
