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
            Assert::notEmpty($this->formModelName, 'Form model name not defined.');

            Assert::notEmpty($this->formModel, 'Form model not found: ' . $this->formModelName);
            
            $data = $this->formModel->createEntity($this->request->getGet());

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);

                $data = $this->formModel->entitySetField($data, $this->parentKey, $parentId);
            }

            if (!$this->userCanMethod($this->user, $method, $data, $parent))
            {
                $this->throwSecurityException('Access denied.');
            }

            return $this->respondOK([
                'data' => $data->toArray(),
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}