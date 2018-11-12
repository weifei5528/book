<?php
namespace app\book\model;

use think\Model;
class Categories extends Model
{
    protected $autoWriteTimestamp = true;

    public static function getList()
    {
        $parentIds = self::where(['pid' => 0 , 'status' => 1])->column('id');
        $list = [];
        foreach ($parentIds as $val) {
            self::hasSon($val, $list);
        }
        return self::where('id','in',$list)->column('name','id');
    }
    /**
     * 查询是否有子菜单
     * @param  int $id 分类的id
     * @param  array $list 没有子分类的存储数组
     */
    public static function hasSon($id,&$list)
    {
        if($sonIds = self::where(['pid' => $id ,'status' => 1])->column('id')) {
            foreach ($sonIds as $val) {
                self::hasSon($val,$list);
            }
        } else {
            $list[] = $id;
        }
    }

}

?>