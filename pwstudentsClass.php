<?php

class pwstudentsClass extends ObjectModel
{
    /** @var string Name */
    public $id_pwstudents;
    public $name;
    public $date_birth;
    public $study = 1;
    public $average_ball;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'pwstudents',
        'primary' => 'id_pwstudents',
//      'multilang' => true,
        'fields' => array(
            'name'         => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255),
            'date_birth'   => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => false),
            'study'        => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'average_ball' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'required' => false),
            'date_add'     => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd'     => array('type' => self::TYPE_DATE, 'validate' => 'isDate')
        ),
    );

    public static function getList()
    {
        return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.''.self::$definition['table'].'` ');
    }

    public static function getTopStudent()
    {
        $cacheId = 'pwstudentsClass::getTopStudent' . (int) Context::getContext()->language->id;
        if (!Cache::isStored($cacheId)) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.''.self::$definition['table'].'` ORDER BY average_ball DESC LIMIT 1');
            Cache::store($cacheId, $result);

            return $result;
        }

        return Cache::retrieve($cacheId);
    }

    public static function getBestBall()
    {

        $cacheId = 'pwstudentsClass::getBestBall' . (int) Context::getContext()->language->id;
        if (!Cache::isStored($cacheId)) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT average_ball FROM `'._DB_PREFIX_.''.self::$definition['table'].'` ORDER BY average_ball DESC LIMIT 1');
            Cache::store($cacheId, $result);

            return $result;
        }

        return Cache::retrieve($cacheId);
    }


}
