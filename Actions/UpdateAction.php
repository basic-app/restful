<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class UpdateAction extends \BasicApp\Action\BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {        
            assert($id ? true : false);

            $data = $this->formModel->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            $validationErrors = [];

            $errors = [];

            $body = (array) $this->request->getJSON(true);

            $data = $this->formModel->fillEntity($data, $body);

            if ($this->formModel->save($data->toArray(), $errors))
            {
                $id = $this->formModel->idValue($data);

                assert($id ? true : false);

                $data = $this->formModel->findOrFail($id);

                return $this->respondUpdated([
                    'data' => $data->toArray()
                ]);
            }
        
            return $this->respondInvalidData([
                'data' => $data->toArray(),
                'validationErrors' => (array) $this->formModel->errors(),
                'errors' => (array) $errors
            ]);
        };
    }

}