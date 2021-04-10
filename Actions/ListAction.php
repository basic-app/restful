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
        return function($method)
        {
            $parent = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($this->parentModel, 'Parent model not found.');

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId);

                $parent = $this->parentModel->findOrFail($parentId, 'Parent not found.');

                $this->model->where($this->parentKey, $parentId);
            }

            $elements = $this->model->all();

            return $this->respondOK([
                'elements' => $elements,
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}