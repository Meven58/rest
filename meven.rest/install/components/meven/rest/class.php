<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\Request;
use Meven\Rest;
use Bitrix\Main\Engine\Contract\Controllerable;

Loc::loadLanguageFile(__FILE__);

Loader::includeModule('meven.rest');

class mevenRest extends CBitrixComponent
{
    public $data = [];

    public function sendData(array $data)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        die(json_encode($data));
    }

    public function executeComponent()
    {
        $this->data['rest'] = Rest\Rest::getInstance();

        $this->data['body'] = $this->data['rest']->getBody();

        try {

            $this->data['rest']->setItem($this->data['body']);

            $func = ucfirst($this->data['body']['method']);
            $result = $this->data['rest']->$func();

        } catch (Exception $e) {
            $this->sendData(['error' => $e->getMessage()]);
        }

        $this->sendData($result);
    }
}
