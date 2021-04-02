<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class UpdateAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        $action = $this;

        return function($method, $id) use ($action)
        {
            assert($id ? true : false);

            $data = $action->formModelFindOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            $validationErrors = [];

            $errors = [];

            $body = (array) $this->request->getJSON(true);

            $data = $action->formModelFillEntity($data, $body);

            if ($action->formModelSave($data->toArray(), $errors))
            {
                $data = $action->formModelFindOrFail($id);

                return $this->respondUpdated([
                    'data' => $data->toArray()
                ]);
            }
        
            return $this->respondInvalidData([
                'data' => $data->toArray(),
                'validationErrors' => (array) $action->formModelErrors(),
                'errors' => (array) $errors
            ]);
        };
    }

}