<?php
namespace app\index\controller;
use app\index\model\Books as BookModel;
class Play extends Home
{
    /**
     * 
     * @param int $id 图书的id
     */
    private function getInstance($id)
    {
        $type = BookModel::getBookType($id);
        switch ($type) {
            case 2:
                return new Audio();
                break;
            case 3:
                return new Video();
                break;
            default:
                return new Text();
                break;
                
        }
    }
    /**
     * 播放列表
     * @param int $id 图书的id
     */
    public function index($id)
    {
        $instance = $this->getInstance($id);
        return $instance->index($id);
    }
   
}

?>