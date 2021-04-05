<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class ListAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        $action = $this;

        return function($method) use ($action)
        {
            if ($action->parentKey)
            {
                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId);

                $action->model->where($action->parentKey, $parentId);
            }

            $elements = $action->modelAll();

            return $this->respondOK([
                'elements' => $elements
            ]);
        };
    }

}