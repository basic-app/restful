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
        return function($method)
        {    
            $data = $this->formModel->createEntity($this->request->getGet());

            $parent = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($this->parentModel, 'Parent model not found.');

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');

                $parent = $this->parentModel->findOrFail($parentId, 'Parent not found.');

                $data = $this->formModel->entitySetField($data, $this->parentKey, $parentId);
            }

            return $this->respondOK([
                'data' => $data->toArray(),
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}