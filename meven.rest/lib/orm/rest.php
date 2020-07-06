<?php
namespace Meven\Rest\ORM;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class BasketTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> product_id int optional
 * <li> user_id int optional
 * <li> date datetime optional
 * <li> price double optional
 * <li> quantity int optional
 * <li> props string(100) optional
 * </ul>
 *
 * @package Bitrix\Basket
 **/

class RestTable extends Main\Entity\DataManager
{
	private static $instance = NULL;

	private function __construct()
	{

	}

	public static function getInstance()
    {
        if (self::$instance === NULL)
        {
            self::$instance = new RestTable();
        }

        return self::$instance;
    }

    public function get($user) : array
    {
        $result = [];

        return $result;
    }

    public function set(array $info)
    {

    }
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'meven_rest';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('REST_ENTITY_ID_FIELD'),
			),
			'name' => array(
				'data_type' => 'string',
                'required' => true,
				'title' => Loc::getMessage('REST_ENTITY_NAME_FIELD'),
			),
			'address' => array(
				'data_type' => 'string',
                'required' => true,
				'title' => Loc::getMessage('REST_ENTITY_ADDRESS_FIELD'),
			),
			'updated_at' => array(
				'data_type' => 'datetime',
				'title' => Loc::getMessage('REST_ENTITY_UPDATED_FIELD'),
			),
			'created_at' => array(
				'data_type' => 'datetime',
				'title' => Loc::getMessage('REST_ENTITY_CREATED_FIELD'),
			),
		);
	}

	/**
	 * Returns validators for props field.
	 *
	 * @return array
	 */
	public static function validateProps()
	{
		return array(
			new Main\Entity\Validator\Length(null, 100),
		);
	}

    public static function onBeforeUpdate(Main\Entity\Event $event)
    {
        $result = new Main\Entity\EventResult;
        $data = $event->getParameter("fields");
        $result->modifyFields(['updated_at' => new \Bitrix\Main\Type\DateTime()]);

        return $result;
    }

    public static function onBeforeAdd(Main\Entity\Event $event)
    {
        $result = new Main\Entity\EventResult;
        $data = $event->getParameter("fields");
        $result->modifyFields([
            'updated_at' => new \Bitrix\Main\Type\DateTime(),
            'created_at' => new \Bitrix\Main\Type\DateTime()
        ]);
        $data = $event->getParameter("fields");

        return $result;
    }
}
