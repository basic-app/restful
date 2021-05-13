<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

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
                    $this->searchModel->applyToQuery($search, $this->model);
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
                $result['elements'] = $this->model->paginate((int) $this->perPage);

                $result['currentPage'] = $this->model->pager->getCurrentPage();

                $result['perPage'] = $this->model->pager->getPerPage();

                $result['pageCount'] = $this->model->pager->getPageCount();

                $result['total'] = $this->model->pager->getTotal();
            }
            else
            {
                $result['elements'] = $this->model->all();
            }

            return $this->respondOK($result);
        };
    }

}