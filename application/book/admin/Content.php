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
}

?>