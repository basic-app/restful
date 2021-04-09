<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class NewAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        $action = $this;

        return function($method) use ($action)
        {    
            $data = $action->formModelCreateEntity($this->request->getGet());

            $parent = null;

            if ($action->parentKey)
            {
                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');

                $parent = $action->parentModelFindOrFail($parentId, 'Parent not found.');

                $data = $action->formModelEntitySetField($data, $action->parentKey, $parentId);
            }

            return $this->respondOK([
                'data' => $data->toArray(),
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}