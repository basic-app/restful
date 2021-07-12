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

class IndexAction extends BaseAction
{

    use ParentTrait;

    use SearchTrait;

    use SortTrait;

    public $beforeIndex;

    public function initialize()
    {
        parent::initialize();

        $this->initializeParent();

        $this->initializeSearch();

        $this->initializeSort();
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            if ($action->parentKey)
            {
                $action->model->where($action->parentKey, $action->parentId);
            }

            $errors = [];

            $validationErrors = [];

            if ($action->beforeIndex)
            {
                $result = $this->trigger($action->beforeIndex, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'parentModel' => $action->parentModel,
                    'parentData' => $action->parentData,
                    'searchModel' => $action->searchModel,
                    'searchData' => $action->searchData,
                    'errors' => $errors,
                    'validationErrors' => $validationErrors,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }

                $errors = $result['errors'];

                $validationErrors = $result['validationErrors'];
            }

            if ($action->searchModel)
            {
                if ($action->searchModel->validate($action->searchData->toRawArray(), $errors))
                {
                    $action->searchData->applyToQuery($action->model);
                }
                else
                {
                    return $this->respondInvalidData([
                        'errors' => (array) $errors,
                        'validationErrors' => (array) $action->searchModel->errors()
                    ]);
                }
            }

            $result = [];

            $result['parentData'] = $action->parentData;
            
            $result['searchData'] = $action->searchData;

            if ($this->sortLabels !== null)
            {
                $result['sortLabels'] = $this->sortLabels;
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

                $result['elements'] = $action->model->prepareBuilder()->paginate($perPage);
                $result['currentPage'] = $action->model->pager->getCurrentPage();
                $result['perPage'] = $action->model->pager->getPerPage();
                $result['pageCount'] = $action->model->pager->getPageCount();
                $result['total'] = $action->model->pager->getTotal();

                return $this->respondOK($result);
            }
            else
            {
                $result['elements'] = $action->model->prepareBuilder()->findAll();
            
                return $this->respondOK($result);
            }
        };
    }

}