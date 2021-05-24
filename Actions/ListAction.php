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

class ListAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method)
        {
            Assert::notEmpty($this->modelName, 'Model name not defined.');

            Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);

            $parent = null;

            if ($this->parentKey)
            {
                $parent = $this->getParent();

                $parentId = $this->parentModel->entityPrimaryKey($parent);

                $this->model->where($this->parentKey, $parentId);
            }

            if (!$this->userCanMethod($this->user, $method, $parent))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            $result = [];

            if ($parent)
            {
                $result['parent'] = $parent;
            }

            $errors = [];

            $validationErrors = [];

            if ($this->searchModelName)
            {
                Assert::notEmpty($this->searchModel, 'Search model not found: ' . $this->searchModelName);

                $search = $this->searchModel->createData($this->request->getGet());

                if ($this->searchModel->validate($search, $errors))
                {
                    $search->applyToQuery($this->model);

                    $result['search'] = $search->toArray();
                }
                else
                {
                    return $this->respondValidationErrors([
                        'errors' => (array) $errors,
                        'validationErrors' => (array) $this->searchModel->errors()
                    ]);
                }
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

                $result['elements'] = $this->model->prepareBuilder()->paginate($perPage);

                $result['currentPage'] = $this->model->pager->getCurrentPage();

                $result['perPage'] = $this->model->pager->getPerPage();

                $result['pageCount'] = $this->model->pager->getPageCount();

                $result['total'] = $this->model->pager->getTotal();
            }
            else
            {
                $result['elements'] = $this->model->prepareBuilder()->findAll();
            }

            return $this->respondOK($result);
        };
    }

}