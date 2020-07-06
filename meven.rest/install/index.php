<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Application;

\Bitrix\Main\Loader::includeModule('meven.logs');

Loc::loadMessages(__FILE__);

Class meven_rest extends CModule
{
    const MODULE_ID = 'meven.rest';
    var $MODULE_ID = 'meven.rest';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $strError = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__)."/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("meven.rest_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("meven.rest_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("meven.rest_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("meven.rest_PARTNER_URI");
    }

    function InstallDB($arParams = array())
    {
        global $DB, $DBType, $APPLICATION;
        $this->errors = false;

        $this->errors = $DB->RunSQLBatch(__DIR__ . "/db/" . $DBType . "/install.sql");

        if ($this->errors !== false) {
            $APPLICATION->ThrowException(implode("", $this->errors));
            return false;
        }

        return true;
    }

    function UnInstallDB($arParams = array())
    {
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function DoInstall()
    {
        $installDB = $this->InstallDB();
        if ($installDB) {
            RegisterModule(self::MODULE_ID);
        }

        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/meven.rest/install/components",
            $_SERVER["DOCUMENT_ROOT"]."/bitrix/components",
            true,
            true
        );
    }

    function DoUninstall()
    {
        UnRegisterModule(self::MODULE_ID);
    }
}
?>
