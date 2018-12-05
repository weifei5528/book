<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\index\controller;

use app\common\controller\Common;
use app\index\model\Categories as CategoryModel;
use app\index\model\Books as BookModel;
/**
 * 前台公共控制器
 * @package app\index\controller
 */
class Home extends Common
{
    protected $original = true;//原始地址
    /**
     * 初始化方法
     * @author 蔡伟明 <314013107@qq.com>
     */
    protected function _initialize()
    {
        // 系统开关
        if (!config('web_site_status')) {
            $this->error('站点已经关闭，请稍后访问~');
        }
        \think\Hook::listen("response_send");
    }
    /**
     * 获取分类
     */
    protected function getAllCategories()
    {

    }
    /**
     * 随机分类
     * @param int $num 默认的随机获得的子分类个数
     * @return array
     */
    protected function getRandomCatgory($num = 3)
    {
        $list = CategoryModel::getRandomCat($num);
        return $list;
    }
    
    /**
     * 设置分类
     */
    protected function setCategory()
    {
        $categories = $this->getRandomCatgory();
        foreach ($categories as $key => &$val) {
            $val['info_list'] = BookModel::getRandomList($val['id']);
        }
        
        
        $this->assign('category_list',CategoryModel::getAllCategories());
        $this->assign('list',$categories);
    }
}
