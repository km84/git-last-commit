<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use Application\Util\Git\ServiceFactory;
use Application\Util\Git\GitGetLastCommitInterface;

class GitApiController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function getLastCommitAction() {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('Application can run only in console.');
        }

        $repositoryName = $request->getParam('repository');
        $branchName = $request->getParam('branch');
        // @TODO nie dawać defaultowych wartości
        $serviceName = !empty($request->getParam('service')) ? $request->getParam('service') : 'github';
        $serviceFactory = new ServiceFactory();
        
        try {
            $serviceClient = $serviceFactory->createServiceWithName($serviceName);
            $serviceClient->setRepository($repositoryName);
            $serviceClient->setBranch($branchName);
            if ($serviceClient instanceof GitGetLastCommitInterface) {
                $lastCommitHash = $serviceClient->getLastCommit();
            } else {
                throw new \Exception(sprintf('Service client "%s" does not implement "%s"', basename(get_class($serviceClient)), 'GitGetLastCommitInterface'));
            }
        } catch (\Application\Util\Git\Exception\ServiceNotFoundException $ex) {
            return sprintf('%s: %s', 'ServiceNotFoundException', $ex->getMessage());
        } catch (\InvalidArgumentException $ex) {
            return sprintf("Invalid argument error: %s", $ex->getMessage());
        } catch (\Exception $ex) {
            return sprintf("Application error: %s", $ex->getMessage());
        }

        return sprintf('%s', $lastCommitHash. PHP_EOL);
    }

}
