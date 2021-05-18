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
            Assert::notEmpty($this->createModelName, 'Create model name not defined.');

            Assert::notEmpty($this->createModel, 'Create model not found: ' . $this->createModelName);
            
            $defaults = [];

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);
            
                $defaults[$this->parentKey] = $parentId;
            }

            $data = $this->createModel->createData($defaults);

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