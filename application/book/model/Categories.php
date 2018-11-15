<?php
namespace app\book\model;

use think\Model;
use util\Tree;
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
    /**
     * 查询分类的名称
     * @param int $id 分类的id
     */
    public static function getName($id)
    {
        return self::where(['id' => $id])->value('name');
    }
    /**
     * 获取树形节点
     * @param int $id 需要隐藏的节点id
     * @param string $default 默认第一个节点项，默认为“顶级节点”，如果为false则不显示，也可传入其他名称
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public static function getMenuTree($id = 0, $default = '')
    {
        $result[0]       = '顶级分类';
        $where['status'] = ['egt', 0];
       
    
        // 排除指定节点及其子节点
        if ($id !== 0) {
            $hide_ids    = array_merge([$id], self::getChildsId($id));
            $where['id'] = ['notin', $hide_ids];
        }
    
        // 获取节点
        $menus = Tree::toList(self::where($where)->order('pid,id')->column('id,pid,name as title'));
        foreach ($menus as $menu) {
            $result[$menu['id']] = $menu['title_display'];
        }
    
        // 设置默认节点项标题
        if ($default != '') {
            $result[0] = $default;
        }
    
        // 隐藏默认节点项
        if ($default === false) {
            unset($result[0]);
        }
    
        return $result;
    }
}

?>