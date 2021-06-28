<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use Exception;
use Config\Services;

class IndexAction extends \BasicApp\Action\Action
{

    public $modelName;

    public $parentModelName;

    public $searchModelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        $searchModelName = $this->searchModelName;

        $parentModelName = $this->parentModelName;

        return function($method) use ($modelName, $parentModelName, $searchModelName)
        {
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);
            
            $parent = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($parentModelName, 'Parent model not defined.');

                $parentModel = model($parentModelName, false);

                Assert::notEmpty($parentModel, 'Parent model not found: ' . $parentModelName);

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');
                
                $this->parentData = $parentModel->findOrFail($parentId, 'Parent not found.');

                $parentId = $parentModel->getIdValue($this->parentData);

                $model->where($this->parentKey, $parentId);
            }

            if (!$this->userCanMethod($this->user, $method, $parent))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $result = [];

            $errors = [];

            $validationErrors = [];

            if ($searchModelName)
            {
                $searchModel = model($searchModelName, false);

                Assert::notEmpty($searchModel, 'Search model not found: ' . $searchModelName);

                $searchData = $searchModel->createData($this->request->getGet());

                if ($searchModel->validate($searchData->toRawArray(), $errors))
                {
                    $searchData->applyToQuery($model);
                }
                else
                {
                    return $this->respondInvalidData([
                        'errors' => (array) $errors,
                        'validationErrors' => (array) $searchModel->errors()
                    ]);
                }

                $result['searchData'] = $searchData->toArray();
            }

            if ($this->perPage)
            {
                $perPage = (int) $this->request->getGet('perPage');

                if (!$perPage)
                {
                    $perPage = $this->perPage;
                }

                if ($this->perPageItems)
                {
                    $validation = Services::validation();

                    if (!$validation->check($perPage, 'in_list[' . implode(', ', $this->perPageItems) . ']'))
                    {
                        $errors = $validation->getErrors('check');

                        $error = $errors['check'];

                        $error = str_replace('check', 'perPage', $error);

                        throw new Exception($error);
                    }
                }

                $result['elements'] = $model->prepareBuilder()->paginate($perPage);

                $result['currentPage'] = $model->pager->getCurrentPage();

                $result['perPage'] = $model->pager->getPerPage();

                $result['pageCount'] = $model->pager->getPageCount();

                $result['total'] = $model->pager->getTotal();
            }
            else
            {
                $result['elements'] = $model->prepareBuilder()->findAll();
            }

            return $this->respondOK($result);
        };
    }

}