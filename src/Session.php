<?php
namespace Itxiao6\Session;
use Itxiao6\Session\Storage\Local;
use Itxiao6\Session\Storage\Mysql;

/**
 * Class Session
 * @package Itxiao6\Session
 */
class Session
{
    /**
     * 存储接口
     * @var array
     */
    protected static $interfaces = [
        'Local'=>Local::class,
        'Redis'=>Local::class,
        'Mysql'=>Mysql::class
    ];
    /**
     * 使用驱动
     * @var bool | string
     */
    protected static $driver = 'Local';

    /**
     * 定义session 是否已经启动
     * @var bool
     */
    protected static $session_status = false;

    /**
     * 设置使用的驱动
     * @param $type
     */
    public static function set_driver($type)
    {
        self::$driver = $type;
    }

    /**
     * 获取驱动
     * @return bool|string
     */
    public static function get_driver()
    {
        return self::$driver;
    }

    /**
     * 获取存储接口
     * @param null | string $key
     * @return array|mixed
     */
    public static function get_interface($key = null)
    {
        if(self::$key!=null){
            return self::$interfaces[$key];
        }else{
            return self::$interfaces;
        }
    }

    /**
     * 设置存储接口
     * @param null | array | string $key
     * @param null | value $value
     */
    public static function set_interface($key = null,$value = null)
    {
        if(is_array($key) && $value==null){
            foreach ($key as $key=>$val){
                self::$interfaces[$key] = $val;
            }
        }else{
            self::$interfaces[$key] = $value;
        }
    }

    /**
     * 启动session 回话
     */
    public static function session_start()
    {
        if(self::$session_status){
            return false;
        }
        /**
         * 实例化存储器
         */
        new self::$interfaces[self::$driver](...func_get_args());

        /**
         * 启动session
         */
        session_start();
        /**
         * 定义session 已经启动
         */
        self::$session_status = true;
    }
}