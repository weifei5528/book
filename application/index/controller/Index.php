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

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    public function index()
    {
        $this->setCategory();
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
     *
     */
    public function getCategory()
    {
        $list = CategoryModel::where(['pid' => 0])->field('id,name')->select();
        foreach ($list as $k => &$v) {
            $sons = CategoryModel::where(['pid' => $v['id']])->field('name,img')->select();
            foreach ($sons as &$val) {
                $val['logo'] = "http://feiyueweb.com".get_file_path($val['img']);
            }
            $v['subCategoryList'] = $sons;
        }
       
       return  json($list);
    }
}
