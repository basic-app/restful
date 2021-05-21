<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class CreateAction extends BaseAction
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

            if (!$this->userCanMethod($this->user, $method, $data))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $data->fill(array_merge($this->request->getGet(), $this->request->getJSON(true)), true);

            if ($this->createModel->save($data, $errors))
            {
                return $this->respondCreated([
                    'insertID' => $this->createModel->insertID
                ]);
            }

            $result = [
                'data' => $data,
                'validationErrors' => (array) $this->createModel->errors(),
                'errors' => (array) $errors
            ];

            if ($parent)
            {
                $result['parent'] = $parent;
            }
        
            return $this->respondInvalidData($result);
        };
    }

}