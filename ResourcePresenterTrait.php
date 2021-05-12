<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait ResourcePresenterTrait
{

    protected $viewsNamespace;

    protected $perPage = 25;

    protected function getViewsNamespace() : ?string
    {
        return $this->viewsNamespace;
    }

    protected function render(string $view, array $params = []) : string
    {
        $namespace = $this->getViewsNamespace();

        return view($namespace ?  $namespace . "\\" . $view : $view, $params);
    }

}