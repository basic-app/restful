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
            Assert::notEmpty($this->formModel, 'Form model not found.');

            $default = $this->request->getGet();

            $data = $this->formModel->createEntity($default);

            $validationErrors = [];

            $errors = [];

            $data = $this->formModel->fillEntity($data, (array) $this->request->getJSON(true));

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);

                $data = $this->formModel->entitySetField($data, $this->parentKey, $parentId);
            }

            if ($this->formModel->save($data->toArray(), $errors))
            {
                return $this->respondCreated([
                    'insertID' => $this->formModel->insertID()
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