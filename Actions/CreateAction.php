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
        return function($method)
        {
            $default = $this->request->getGet();

            $data = $this->formModel->createEntity($default);

            $validationErrors = [];

            $errors = [];

            $data = $this->formModel->fillEntity($data, (array) $this->request->getJSON(true));

            $parent = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($this->parentModel, 'Parent model not found.');

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');

                $parent = $this->parentModel->findOrFail($parentId, 'Parent not found.');

                $data = $this->formModel->entitySetField($data, $this->parentKey, $parentId);
            }

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
                    'data' => $data->toArray(),
                    'parent' => $parent ? $parent->toArray() : null
                ]);
            }
        
            return $this->respondInvalidData([
                'data' => $data->toArray(),
                'validationErrors' => (array) $this->formModel->errors(),
                'errors' => (array) $errors,
                'parent' => $parent ? $parent->toArray() : null
            ]);
        };
    }

}