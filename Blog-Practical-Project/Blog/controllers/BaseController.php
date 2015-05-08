<?php
namespace Controllers;

use GFramework\App;
use GFramework\InputData;
use GFramework\View;
use GFramework\Sessions\iSession;
use GFramework\Config;

abstract class  BaseController
{
    /**
     * @var \GFramework\App
     */
    protected $app;
    /**
     * @var View
     */
    protected $view;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var \GFramework\InputData
     */
    protected $input;
    /**
     * @var iSession
     */
    protected $session;
    protected $viewData = array();

    function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->session = $this->app->getSession();
        $this->input = InputData::getInstance();

        $page = $this->readPageNumber();
        $this->viewData = array(
            'page' => $page,
        );

        $this->view->appendLayout('startPage', 'htmlParts.startHTML');
        $this->view->appendLayout('endPage', 'htmlParts.endHTML');
        $this->view->appendLayout('header', 'htmlParts.header');
        $this->view->appendLayout('errors', 'htmlParts.errorsMessages');
        $this->view->appendLayout('menu', 'htmlParts.menu');
        $this->view->appendLayout('categories', 'htmlParts.categories');
        $this->view->appendLayout('problem', 'htmlParts.problem');
        $this->view->appendLayout('pagination', 'htmlParts.pagination');
        $this->view->appendLayout('problem-form', 'htmlParts.problem-form');
        $this->view->appendLayout('problem-solution', 'htmlParts.problem-solution-textarea');
        $this->view->appendLayout('solution', 'htmlParts.solution');
        $this->view->appendLayout('history', 'htmlParts.history-path');

        if (!$this->session->hasSessionProperty('refererPage')) {
            $this->session->refererPage = $_SERVER['HTTP_REFERER'];
        }
    }


    protected function redirect($url)
    {
        if ($url) {
            header("Location: $url");
            die;
        } else {
            throw new \Exception('Invalid url', 500);
        }
    }


    protected function redirectWhenUserIsNotLogged($url)
    {
        if (!$this->session->username) {
            if ($url) {
                header("Location: $url");
                die;
            } else {
                throw new \Exception('Invalid url', 500);
            }
        }
    }


    protected function redirectWhenUserIsLogged($url)
    {
        if ($this->session->username) {
            if ($url) {
                header("Location: $url");
                die;
            } else {
                throw new \Exception('Invalid url', 500);
            }
        }
    }


    /**
     * @param array $data
     */
    protected function addViewData($data)
    {
        $this->viewData = array_merge($this->viewData, $data);
    }


    /**
     * @return int
     */
    private function readPageNumber()
    {
        $id = 0;
        $page = 1;
        $param = true;
        while ($param) {
            $param = $this->input->get($id);
            if ($param == 'page') {
                $page = $this->input->get($id + 1);
                break;
            }

            $id++;
        }

        return (int) $page;
    }


    public  function getMaxPage($count)
    {
        $pageSize = $this->config->app['pageSize'];
        $maxPage = (int)($count / $pageSize);
        if (($count % $pageSize) > 0) {
            $maxPage++;
        }

        return $maxPage;
    }


    protected function saveHistoryPath($position, $key)
    {
        if ($this->session->hasSessionProperty('history')) {
            $history = $this->session->history;
        }

        $history[$position]['key'] = $key;
        $history[$position]['path'] = $_SERVER['PATH_INFO'];
        unset($history[$position + 1]);
        unset($history[$position + 2]);
        unset($history[$position + 3]);

        $this->session->history = $history;
    }


    protected function getLastHistoryPath()
    {
        $history = $this->session->history;
        return end($history)['path'];
    }

    protected function getHistoryPathByPosition($position)
    {
        $history = $this->session->history;
        return $history[$position]['path'];
    }

    public function __call($name, $arguments) {
        throw new \Exception("Method $name is not implemented.", 501);
    }
}