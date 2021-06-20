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

    protected function render(string $view, array $params = []) : string
    {
        return view($this->viewsNamespace ? $this->viewsNamespace . "\\" . $view : $view, $params);
    }

}