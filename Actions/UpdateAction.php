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
            Assert::notEmpty($this->formModelName, 'Form model name not defined.');

            Assert::notEmpty($this->formModel, 'Form model not found: ' . $this->formModelName);
            
            $data = $this->formModel->findOne($id);

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

            $body = (array) $this->request->getJSON(true);

            $data = $this->formModel->fillEntity($data, $body);

            if ($this->formModel->save($data, $errors))
            {
                return $this->respondUpdated();
            }

            $result = [
                'data' => $data,
                'validationErrors' => (array) $this->formModel->errors(),
                'errors' => (array) $errors
            ];
        
            return $this->respondInvalidData($result);
        };
    }

}