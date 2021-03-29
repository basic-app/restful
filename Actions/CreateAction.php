<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class CreateAction extends \BasicApp\Action\BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method)
        {
            $data = $this->formModel->createEntity($this->request->getGet());

            $validationErrors = [];

            $errors = [];

            $body = $this->request->getJSON(true);

            $data = $this->formModel->fillEntity($data, $body, $hasChanged);

            if ($hasChanged && $this->formModel->save($data->toArray(), $errors))
            {
                $id = $this->formModel->insertID();

                if (!$id)
                {
                    return $this->respondCreated();
                }

                $data = $this->formModel->findOrFail($id);
            
                return $this->respondCreated([
                    'insertID' => $id,
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