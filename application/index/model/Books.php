<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/18
 * Time: 21:51
 */

namespace app\index\model;


use think\Model;

class Books extends Model
{
    protected $autoWriteTimestamp = true ;

    public static function getRandomList($cat_id, $num = 10 )
    {
        $data = self::where(['status' => 1 ,'cat_id' => $cat_id, ])->column('name','id');
        if(empty($data))
            return [];
        $num = count($data) < $num ? count($data) : $num ;
        $rand_keys = array_rand($data,$num);
        return self::where(['id' => ['in', $rand_keys]])->select();
    }
    /**
     * 获取指定的图书的类型
     * @param int $id  图书的id
     */
    public static function getBookType($id)
    {
        return self::where(['id' => $id])->value('type');
    }
    /**
     * 获取图书的封面
     * @param
     */
    public static function getImg($id)
    {
        return self::where(['id' => $id])->value('img');
    }
}