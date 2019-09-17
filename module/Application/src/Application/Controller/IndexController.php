<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function getLastCommitAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('Program może być uruchomiony tylko w trybie konsolowym.');
        }

        $repository = $request->getParam('repository');
        $branch = $request->getParam('branch');
        $service = !empty($request->getParam('service')) ? $request->getParam('service') : 'github';
        $githubClient = new \Application\Util\Git\Service\Github();
        $serviceFactory = new \Application\Util\Git\ServiceFactory();
        try {
             $serviceClient = $serviceFactory->createServiceWithName($service);
             $serviceClient->setRepository($repository);
             $serviceClient->setBranch($branch);
             return $serviceClient->getLastCommit();
        } catch (\Application\Util\Git\Exception\ServiceNotFoundException $ex) {
            return $ex->getMessage();
        }
        
//        $gitServiceClientFactory = new GitServiceClientFactory();
//        $gitClient = $gitServiceClientFactory->getServiceAdapter($service); // getURI($resource) or getLastCommitURI()
//        
//        $gitClient->setResource($repository);
//        $gitClient->setBranch($branch);
        
        \debug_zval_dump($repository);
        \debug_zval_dump($branch);
        \debug_zval_dump($service);
        
        return 'test';
    }
}