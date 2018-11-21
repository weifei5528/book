<?php
namespace app\index\controller;
use app\index\model\BookAudios as AudioModel;
use app\index\model\Attachment as AttModel;
use app\index\model\Books as BookModel;
class Audio extends Home
{
    protected function _initialize(){
        parent::_initialize();
        config('paginate.type','\app\index\page\PageRow');
    }
    /**
     * 播放音频列表
     * @param int $id 图书的id 
     */
    public function index($id)
    {
        $this->setCategory();
        $list = AudioModel::getList($id);
        foreach ($list as $k => &$v) {
            $info = AttModel::get($v['book_id']);
            $v['size'] = format_bytes($info['size']);
        }
        $this->assign('list',$list);
        //唱片的图片
        $this->assign('bookinfo',BookModel::get($id));
        $this->assign('title',"详情");
        return $this->fetch('audio/index');
    }
    /**
     * 返回音频的地址
     */
    public function getMp3Addr($id)
    {
        if($this->original) {
            return AudioModel::getOriginalAddr($id);
        } else {
            return get_file_path($id);
        }
    }
}

?>