<?php
namespace app\book\admin;

use app\admin\controller\Admin;
use app\book\model\Books as BookModel;
class Content extends Admin
{
    
    /**
     * 内容列表
     * @param int $id 图书id
     */
    public function index($id)
    {
        return $this->getBookType($id)->index($id);
    }
    
    private function getBookType($id)
    {
        $type = BookModel::getType($id);
        $instance = null;
        switch ($type) {
            case 1:
                break;
            case 2:
                $instance = new Audio();
                break;
            case 3:
               break;
            default:
                break;
        }
        return $instance;
    }
    /**
     * 添加内容
     */
    public function addcontent($id)
    {
        return $this->getBookType($id)->addcontent($id);
    }
    /**
     * 编辑
     */
    public function edit($id = '')
    {
        return $this->getBookType($id)->edit($id);
    }
    /**
     * 禁用
     */
    public function mydisable( $id, $record = [])
    {
        return $this->getBookType($id)->disable($record);
    }
    /**
     * 启用
     */
    public function myenable($id, $record = [])
    {
        return $this->getBookType($id)->enable($record);
    }
    /**
     * 删除
     */
    public function mydelete($id, $record = [])
    {
        return $this->getBookType($id)->delete($record);
    }
}

?>