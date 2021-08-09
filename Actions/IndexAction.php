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

    public $responseParams = [];

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

            $response = $action->responseParams;

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
                    'responseParams' => $response,
                    'response' => null
                ]);

                if ($result['response'] !== null)
                {
                    return $result['response'];
                }

                $errors = $result['errors'];

                $validationErrors = $result['validationErrors'];

                $response = array_merge($response, $result['responseParams']);
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

            $response['parentData'] = $action->parentData;
            
            $response['searchData'] = $action->searchData;

            $sortLabels = $action->getSortLabels();

            if ($sortLabels !== null)
            {
                $response['sortLabels'] = $sortLabels;
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

                $response['elements'] = $action->model->prepareBuilder()->paginate($perPage);
                $response['currentPage'] = $action->model->pager->getCurrentPage();
                $response['perPage'] = $action->model->pager->getPerPage();
                $response['pageCount'] = $action->model->pager->getPageCount();
                $response['total'] = $action->model->pager->getTotal();

                return $this->respondOK($response);
            }
            else
            {
                $response['elements'] = $action->model->prepareBuilder()->findAll();
            
                return $this->respondOK($response);
            }
        };
    }

}