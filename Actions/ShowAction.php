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

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            Assert::notEmpty($this->model, 'Model not found.');

            $data = $this->model->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respondOK([
                'data' => $data->toArray()
            ]);
        };
    }

}