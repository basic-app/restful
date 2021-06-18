<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class ShowAction extends BaseAction
{

    public function run($method, ...$params)
    {
        return function($method, $id)
        {
            Assert::notEmpty($this->modelName, 'Model name not defined.');

            Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);

            $this->data = $this->model->prepareBuilder()->findOne($id);

            if (!$this->data)
            {
                return $this->failNotFound();
            }

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $result = [
                'data' => $this->data
            ];

            return $this->respondOK($result);
        };
    }

}