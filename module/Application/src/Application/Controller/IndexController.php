<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;

class IndexController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function getLastCommitAction() {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('Program może być uruchomiony tylko w trybie konsolowym.');
        }

        $repositoryName = $request->getParam('repository');
        $branchName = $request->getParam('branch');
        $serviceName = !empty($request->getParam('service')) ? $request->getParam('service') : 'github';
        $serviceFactory = new \Application\Util\Git\ServiceFactory();
        
        try {
            $serviceClient = $serviceFactory->createServiceWithName($serviceName);
            $serviceClient->setRepository($repositoryName);
            $serviceClient->setBranch($branchName);
            $lastCommitHash = $serviceClient->getLastCommit();
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
