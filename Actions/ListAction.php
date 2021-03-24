<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class ListAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method)
        {
            assert($this->model ? true : false);
            
            $elements = $this->modelFindAll();

            return $this->respond([
                'elements' => $elements
            ]);
        };
    }

}