<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class EditAction extends BaseAction
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

            $result = [
                'data' => $data
            ];

            return $this->respondOK($result);
        };
    }

}