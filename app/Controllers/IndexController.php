<?php

namespace Controllers;

use JasonGrimes\Paginator;

class IndexController extends BaseController
{
    
    public function getIndex($pageNum = null)
    {
        if( isset($pageNum) ) {
            $offset = (int)$pageNum;
        } else {
            $offset = 1;
        }
        $maxPerPage = 3;
    
        $taskRepository = $this->em->getRepository('Models\\Task');
        $tasks = $taskRepository->findBy(
            array(),
            array(),
            $maxPerPage,
            $maxPerPage * ($offset -1)
        );

        $totalItems = count($taskRepository->findAll());
        $currentPage = 1;
        $urlPattern = '(:num)';

        $session = $this->session->get('auth');

        $paginator = new Paginator($totalItems, $maxPerPage, $currentPage, $urlPattern);

        return $this->blade->make('index',[
            'tasks' => $tasks,
            'paginator' => $paginator,
            'session' => $session
        ]);
    }

}
