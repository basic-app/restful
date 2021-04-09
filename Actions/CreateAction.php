<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

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

            $parent = null;

            if ($action->parentKey)
            {
                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');

                $parent = $action->parentModelFindOrFail($parentId, 'Parent not found.');

                $data = $action->formModelEntitySetField($data, $action->parentKey, $parentId);
            }

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
                    'data' => $data->toArray(),
                    'parent' => $parent ? $parent->toArray() : null
                ]);
            }
        
            return $this->respondInvalidData([
                'data' => $data->toArray(),
                'validationErrors' => $action->formModelErrors(),
                'errors' => (array) $errors,
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}