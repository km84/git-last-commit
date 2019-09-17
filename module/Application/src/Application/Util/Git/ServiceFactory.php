<?php
namespace Application\Util\Git;

/**
 * Tworzy prostego klienta do obsługi wybranego hostingu gita. 
 */
class ServiceFactory implements AbstractFactoryInterface {
    public function createServiceWithName(string $service) : GitServiceInterface {
        if (class_exists("Application\\Util\\Git\\Service\\{$service}")) {
            $className =  "Application\\Util\\Git\\Service\\{$service}";
            return new $className;
        }
        throw new Exception\ServiceNotFoundException(sprintf('Unknown service "%s"', $service));
    }
}
