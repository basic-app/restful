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

    public function run($method, ...$params)
    {
        return function($method)
        {    
            Assert::notEmpty($this->createModelName, 'Create model name not defined.');

            Assert::notEmpty($this->createModel, 'Create model not found: ' . $this->createModelName);
            
            $defaults = [];

            if ($this->parentKey)
            {
                $this->parentData = $this->getParent();

                $parentId = $this->parentModel->getIdValue($this->parentData);
            
                $defaults[$this->parentKey] = $parentId;
            }

            $this->data = $this->createModel->createData($defaults);

            $this->data->fill($this->request->getGet());

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $result = [
                'data' => $this->data
            ];

            /*
            if ($parent)
            {
                $result['parentData'] = $this->parentData;
            }
            */

            return $this->respondOK($result);
        };
    }

}