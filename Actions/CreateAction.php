<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class CreateAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        $action = $this;

        return function($method) use ($action)
        {
            $default = $this->request->getGet();

            $data = $action->formModelCreateEntity($default);

            $validationErrors = [];

            $errors = [];

            $data = $action->formModelFillEntity($data, (array) $this->request->getJSON(true));

            if ($action->formModelSave($data->toArray(), $errors))
            {
                $id = $action->formModelInsertID();

                if (!$id)
                {
                    return $this->respondCreated();
                }

                $data = $action->formModelFindOrFail($id);
            
                return $this->respondCreated([
                    'insertID' => $id,
                    'data' => $data->toArray()
                ]);
            }
        
            return $this->respondInvalidData([
                'data' => $data->toArray(),
                'validationErrors' => $action->formModelErrors(),
                'errors' => (array) $errors
            ]);
        };
    }

}