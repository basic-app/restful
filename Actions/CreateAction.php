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

            if (!$this->userCanMethod($this->user, $method, $data))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $data->fill($this->request->getGet(), true);

            $data->fill($this->request->getJSON(true), true);

            if ($this->formModel->save($data, $errors))
            {
                return $this->respondCreated([
                    'insertID' => $this->formModel->insertID()
                ]);
            }

            $result = [
                'data' => $data,
                'validationErrors' => (array) $this->formModel->errors(),
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