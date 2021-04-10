<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use BasicApp\Action\ActionInterface;

class ResourceController extends BaseResourceController
{

    protected $format = 'json';

    protected $defaultActions = [
        'index' => 'BasicApp\RESTful\Actions\ListAction',
        'new' => 'BasicApp\RESTful\Actions\NewAction',
        'create' => 'BasicApp\RESTful\Actions\CreateAction',
        'show' => 'BasicApp\RESTful\Actions\ShowAction',
        'update' => 'BasicApp\RESTful\Actions\UpdateAction',
        'edit' => 'BasicApp\RESTful\Actions\EditAction',
        'delete' => 'BasicApp\RESTful\Actions\DeleteAction'
    ];

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // instantiate our model, if needed
        $this->setFormModel($this->formModelName);

        $this->setParentModel($this->parentModelName);

        $this->setSearchModel($this->searchModelName);
    }
    
    public function _remap($method, ...$params)
    {
        if (method_exists($this, $method))
        {
            return $this->$method(...$params);
        }

        return $this->remapAction($method, ...$params);
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->remapAction('index');
    }

    /**
     * Return the properties of a resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        return $this->remapAction('show', $id);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        return $this->remapAction('new');
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        return $this->remapAction('create');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        return $this->remapAction('edit', $id);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        return $this->remapAction('update', $id);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        return $this->remapAction('delete', $id);
    }

    protected function createAction(string $className, array $params = []) : ActionInterface
    {
        if ($this->parentKey && !array_key_exists('parentKey', $params))
        {
            $params['parentKey'] = $this->parentKey;
        }

        return parent::createAction($className, $params);
    }

}