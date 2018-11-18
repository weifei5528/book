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
        // 添加
        $btn_add = [
            'title' => '新增',
            'icon'  => 'fa fa-plus-circle',
            'class' =>'btn btn-primary',
            'href'  => url('Content/addcontent',array('id'=>$id))
        ];
        //禁用
        $btn_disable = [
            'title' =>'禁用',
            'icon'  =>'fa fa-ban',
            'class' =>'btn btn-warning ajax-post confirm',
            'href'  =>url('Content/mydisable',array('id' => $id))
        ];
        //启用
        $btn_enable = [
            'title' =>'启用',
            'icon'  =>'fa fa-check-circle-o',
            'class' =>'btn btn-success ajax-post confirm',
            'href'  =>url('Content/myenable',array('id' => $id))
        ];
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
            //->addTopButtons('add,enable,disable') // 批量添加顶部按钮
            ->addTopButton('custom',$btn_add)
        /*    ->addTopButton('custom',$btn_enable)
            ->addTopButton('custom',$btn_disable)*/
            ->addRightButtons('edit') // 批量添加右侧按钮
            ->hideCheckbox()
            ->setRowList($data_list) // 设置表格数据
            ->fetch(); // 渲染模板
    }
    /**
     * 添加音频文件
     */
    public function addcontent($id)
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'BookAudios');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);
            if ($audio = AudioModel::create($data)) {
                // 记录行为
                action_log('audio_add', 'book', $audio['id'], UID);
                $this->success('新增成功', url('index',array('id'=>$id)));
            } else {
                $this->error('新增失败');
            }
        }
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
        ->setPageTitle('新增') // 设置页面标题
        ->addFormItems([ // 批量添加表单项
            ['text', 'name', '名称', '必填，可由汉字、英文字母、数字组成'],
            ['file', 'audio', '音频文件'],
            ['text', 'audio_url', '音频的原始地址'],
            ['hidden', 'book_id', $id],
            ['radio', 'status', '状态', '', ['禁用', '启用'], 1]
        ])
        ->fetch();
    }
    /**
     * 编辑
     */
    public function edit($id = '')
    {
         if(empty($id))
            return $this->error("缺少必要参数！");
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'Category');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);
            if (AudioModel::update($data)) {
                // 记录行为
               
                $this->success('修改成功', url('index',array('id' => $id)));
            } else {
                $this->error('修改失败');
            }
        }
        $info = AudioModel::get($id);
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
        ->setPageTitle('修改') // 设置页面标题
        ->addFormItems([ // 批量添加表单项
           ['text', 'name', '名称', '必填，可由汉字、英文字母、数字组成'],
           ['file', 'audio', '音频文件'],
           ['text', 'audio_url', '音频的原始地址'],
           ['hidden', 'book_id', $id],
           ['radio', 'status', '状态', '', ['禁用', '启用'], 1]
        ])
        ->setFormData($info)
        ->fetch();
        
    }
}

?>