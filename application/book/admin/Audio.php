<?php
namespace app\book\admin;

use app\admin\controller\Admin;
use app\book\model\BookAudios as AudioModel;
use app\common\builder\ZBuilder;
class Audio extends Admin
{
    /**
     * 列表
     */
    public function index($id)
    {
         // 获取查询条件
        $map = $this->getMap();
        $map['book_id'] = $id;
        $order = $this->getOrder();
        // 数据列表
        $data_list = AudioModel::where($map)->order($order)->paginate();
        
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('内容列表') // 页面标题
            ->setTableName('book_audios') // 设置表名
            ->setSearch(['name' => '名称', 'id' => 'ID']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '名称'],
                ['audio','音频文件','files','没有音频文件'],
                ['audio_url','原始地址','url'],
                ['click', '阅读次数'],
                ['status', '状态', 'switch'],
                ['create_time', '添加时间', 'datetime'],
                ['update_time', '更新时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable') // 批量添加顶部按钮
            ->addRightButtons('edit') // 批量添加右侧按钮
            ->setRowList($data_list) // 设置表格数据
            ->fetch(); // 渲染模板
    }
}

?>