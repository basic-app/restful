<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\ActiveEntity\ActiveEntityInterface;

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

            $this->data = $this->createModel->createData($defaults);

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $this->data->fill(array_merge($this->request->getGet(), (array) $this->request->getJSON(true)), true);

            $insertID = null;

            if ($this->data instanceof ActiveEntityInterface)
            {
                $saved = $this->data->save($errors);

                if ($saved)
                {
                    $insertID = $this->data->getInsertID();
                }

                $validationErrors = $this->data->errors();
            }
            else
            {
                $saved = $this->createModel->save($this->data, $errors);

                if ($saved)
                {
                    $insertID = $this->createModel->getInsertID();
                }

                $validationErrors = $this->createModel->errors();
            }

            if ($saved)
            {
                return $this->respondCreated([
                    'insertID' => $insertID
                ]);
            }

            $result = [
                'data' => $this->data,
                'validationErrors' => (array) $validationErrors,
                'errors' => (array) $errors
            ];

            /*

            if ($parent)
            {
                $result['parent'] = $parent;
            }

            */
        
            return $this->respondInvalidData($result);
        };
    }

}