<?php
namespace Meven\Rest;

use Bitrix\Main\Application;
use Meven\Rest\ORM\RestTable;

class Rest
{

    private static $instance = NULL;
    private $data = [];

    public function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == NULL )
            self::$instance = new Rest;

        return self::$instance;
    }

    /**
     * @return mixed
     * @throws \Bitrix\Main\SystemException
     *
     * get array from php://input
     */
    public function getBody()
    {
        $context = Application::getInstance()->getContext();
        $server = $context->getServer();

        $entityBody = file_get_contents('php://input');
        $reqBitrix = $context->getRequest();
        $request = json_decode($entityBody, true);

        return $request;
    }


    /**
     * @param $data
     *
     * Setter for items
     */
    public function setItem($data)
    {
        $this->data['item'] = $data;
    }

    /**
     * @return array
     * @throws \Exception
     *
     * Add elements to table
     */
    public function add()
    {
        $item = [
            'name' => $this->data['item']['name'],
            'address' => $this->data['item']['address']
        ];

        $result = RestTable::add($item);

        if (!$result->isSuccess())
        {
            return ['errors' => $result->getErrors()];
        }

        return ['success' => true];
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     * get all elements
     */
    public function get()
    {
        $row = RestTable::query()
            ->setOrder([
               'id' => 'ASC'
            ])
            ->setSelect([
                '*'
            ]);

        return $row->fetchAll();
    }

    /**
     * @return array
     * @throws \Exception
     *
     * update elements with id
     */
    public function update()
    {
        $item = [
            'name' => $this->data['item']['name'],
            'address' => $this->data['item']['address']
        ];

        $result = RestTable::update($this->data['item']['id'], $item);

        if (!$result->isSuccess())
        {
            return ['errors' => $result->getErrors()];
        }

        return ['success' => true];
    }

    /**
     * @return array
     * @throws \Exception
     *
     * delete element
     */
    public function delete()
    {
        $result = RestTable::delete($this->data['item']['id']);
        if (!$result->isSuccess())
        {
            return ['errors' => $result->getErrorMessages()];
        }

        return ['success' => true];
    }
}
