<?php
/**
 * Created by PhpStorm.
 * User: IMS2.15
 * Date: 2018/11/19
 * Time: 17:06
 */
namespace app\index\model;

use think\Db;
use think\Model;

class IndexModel extends Model{
    public static $tables2='weiq_plus_list_num';

    public function get_data(){
        return Db::name(self::$tables2)->select();
    }
}