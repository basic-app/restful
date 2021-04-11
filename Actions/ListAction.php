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
            Assert::notEmpty($this->model, 'Model not found.');

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);

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