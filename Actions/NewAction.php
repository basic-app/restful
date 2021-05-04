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
            
            $defaults = [];

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);
            
                $defaults[$this->parentKey] = $parentId;
            }

            $data = $this->formModel->createEntity($defaults);

            $data->fill($this->request->getGet(), true);

            if (!$this->userCanMethod($this->user, $method, $data, $parent))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $result = [
                'data' => $data
            ];

            if ($parent)
            {
                $result['parent'] = $parent;
            }

            return $this->respondOK($result);
        };
    }

}