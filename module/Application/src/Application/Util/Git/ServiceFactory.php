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
            $client = new HttpClient();
            $gitService = new $className($client);
            $gitService->setApiUri($this->getServiceDefaultApiUri($serviceName)); // default API
            return $gitService;
        }
        throw new Exception\ServiceNotFoundException(sprintf('Unknown service "%s"', $service));
    }
    
    /**
     * Return default service API URI.
     * 
     * @param string $serviceName
     * @return boolean|string
     */
    private function getServiceDefaultApiUri($serviceName) {
        switch ($serviceName) {
            case 'github': return 'https://api.github.com';
            default: return false;
        }
    }

}
