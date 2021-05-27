<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\ActiveEntity\ActiveEntityInterface;

class UpdateAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            Assert::notEmpty($this->updateModelName, 'Update model name not defined.');

            Assert::notEmpty($this->updateModel, 'Update model not found: ' . $this->updateModelName);
            
            $this->data = $this->updateModel->findOne($id);

            if (!$this->data)
            {
                return $this->failNotFound();
            }

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $this->data->fill($this->request->getJSON(true), true);

            if ($this->data instanceof ActiveEntityInterface)
            {
                $saved = $this->data->save($errors); 
            }
            else
            {
                $saved = $this->updateModel->save($this->data, $errors);
            }

            if ($saved)
            {
                return $this->respondUpdated();
            }

            $result = [
                'data' => $this->data,
                'validationErrors' => (array) $this->updateModel->errors(),
                'errors' => (array) $errors
            ];
        
            return $this->respondInvalidData($result);
        };
    }

}