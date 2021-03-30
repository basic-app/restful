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
            $default = $this->request->getGet();

            $data = $this->formModel->createEntity($default);

            $validationErrors = [];

            $errors = [];

            $data = $this->formModel->fillEntity($data, (array) $this->request->getJSON(true));

            if ($this->formModel->save($data->toArray(), $errors))
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
                'validationErrors' => $this->formModel->errors(),
                'errors' => (array) $errors
            ]);
        };
    }

}