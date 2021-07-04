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

    public $beforeIndex;

    public function initialize(?string $method = null)
    {
        parent::initialize($method);

        $this->initializeParent();

        $this->initializeSearch();
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

                $elements = $model->prepareBuilder()->paginate($perPage);

                return $this->respondOK([
                    'parentData' => $action->parentData,
                    'elements' => $elements,
                    'searchData' => $action->searchData,
                    'currentPage' => $action->model->pager->getCurrentPage(),
                    'perPage' => $action->model->pager->getPerPage(),
                    'pageCount' => $action->model->pager->getPageCount(),
                    'total' => $action->model->pager->getTotal()
                ]);
            }
            else
            {
                $elements = $action->model->prepareBuilder()->findAll();
            
                return $this->respondOK([
                    'parentData' => $action->parentData,
                    'elements' => $elements,
                    'searchData' => $action->searchData
                ]);
            }
        };
    }

}