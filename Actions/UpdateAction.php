<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class UpdateAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            Assert::notEmpty($this->updateModelName, 'Update model name not defined.');

            Assert::notEmpty($this->updateModel, 'Update model not found: ' . $this->updateModelName);
            
            $data = $this->updateModel->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            if (!$this->userCanMethod($this->user, $method, $data))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $data->fill($this->request->getJSON(true), true);

            if ($this->updateModel->save($data, $errors))
            {
                return $this->respondUpdated();
            }

            $result = [
                'data' => $data,
                'validationErrors' => (array) $this->updateModel->errors(),
                'errors' => (array) $errors
            ];
        
            return $this->respondInvalidData($result);
        };
    }

}