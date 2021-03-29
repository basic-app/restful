<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class EditAction extends \BasicApp\Action\BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            $data = $this->formModel->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respondOk([
                'data' => $data->toArray()
            ]);
        };
    }


}