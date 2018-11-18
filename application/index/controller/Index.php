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
use app\index\model\Categories as CategoryModel;
use app\index\model\Books as BookModel;
/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    public function index()
    {
        $categories = $this->getRandomCatgory();
        foreach ($categories as $key => &$val) {
            $val['info_list'] = BookModel::getRandomList($val['id']);
        }


        $this->assign('category_list',CategoryModel::getAllCategories());
        $this->assign('list',$categories);
        $this->assign('page_title','首页');
       return $this->fetch();
    }
    /**
     * 登录或注册
     */
    public function loginorregister()
    {
        return $this->fetch();
    }
    /**
     * 随机分类
     * @param int $num 默认的随机获得的子分类个数
     * @return array
     */
    private function getRandomCatgory($num = 3)
    {
        $list = CategoryModel::getRandomCat($num);
        return $list;
    }
    /**
     *
     */
}
