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
        $action = $this;

        return function($method) use ($action)
        {
            $elements = $action->modelAll();

            return $this->respondOk([
                'elements' => $elements
            ]);
        };
    }

}