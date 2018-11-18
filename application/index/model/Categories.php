<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/17
 * Time: 19:13
 */
namespace app\index\model;
use think\Cache;
use think\Model;

class Categories extends Model
{
    protected $autoWriteTimestamp = true;

    public static function getRandomCat($num = 3 )
    {
        $ids = [];
        if(Cache::has('all_category')) {
            $ids = Cache::get('all_category');
        } else {
             self::getAllSons(0,$ids);
             if($ids) {
                 Cache::set('all_category',$ids,24*60*60);
             }

        }

        if(empty($ids))
            return [];
        shuffle($ids);
        $rand_ids = array_slice($ids,0,3);
        return self::where(['id' => ['in',$rand_ids]])->select();
    }
    /**
     * 所有没有子分类的 最终分类
     */
    public static function getAllSons($id = 0, &$list = null)
    {

        $data = self::where(['pid' => $id, 'status'=>1])->column('id');
        if(count($data) <= 0 ) {
            $list[] = $id;
        } else {
            foreach ($data as  $val) {
                self::getAllSons($val,$list);
            }
        }

    }
    /**
     * 获取所有的分类
     */
    public static function getAllCategories()
    {
        $list = self::where(['pid' => 0, 'status' => 1])->order('create_time desc')->select();
        foreach ($list as $key => &$val) {
            $data = self::where(['pid' => $val['id'], 'status' => 1])->order('create_time desc')->select();
            $val['sons'] = $data;

        }
        return $list;
    }

}