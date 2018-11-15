<?php
namespace app\book\admin;

use app\admin\controller\Admin;
use app\book\model\Categories as CategoryModel;
use app\common\builder\ZBuilder;
class Category extends Admin
{
    public function index()
    {
        // 获取查询条件
        $map = $this->getMap();
        $order = $this->getOrder();
        // 数据列表
        $data_list = CategoryModel::where($map)->order($order)->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
        ->setPageTitle('分类列表') // 页面标题
        ->setTableName('categories') // 设置表名
        ->setSearch(['name' => '分类名称', 'id' => 'ID']) // 设置搜索参数
        ->addColumns([ // 批量添加列
            ['id', 'ID'],
            ['img','封面','picture'],
            ['name', '角色名称'],
            ['status', '状态', 'switch'],
            ['create_time', '添加时间', 'datetime'],
            ['update_time', '更新时间', 'datetime'],
            ['right_button', '操作', 'btn']
        ])
        ->addTopButtons('add,enable,disable') // 批量添加顶部按钮
        ->addRightButtons('edit') // 批量添加右侧按钮
        // ->replaceRightButton(['id' => 1], '<button class="btn btn-danger btn-xs" type="button" disabled>不可操作</button>') // 修改id为1的按钮
        ->setRowList($data_list) // 设置表格数据
        ->fetch(); // 渲染模板
    }
    /**
     * 编辑
     * @param int $id 分类的id
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
            if ($category= CategoryModel::create($data)) {
                // 记录行为
                action_log('catgory_edit', 'book', $category['id'], UID);
                $this->success('新增成功', url('index'));
            } else {
                $this->error('新增失败');
            }
        }
        $info = CategoryModel::get($id);
        $list = CategoryModel::getMenuTree();
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
        ->setPageTitle('新增') // 设置页面标题
        ->addFormItems([ // 批量添加表单项
            ['text', 'name', '分类名称', '必填'],
            ['select','pid','所属分类', '', $list],
            ['radio', 'status', '状态', '', ['禁用', '启用'], 1]
        ])
        ->setFormData($info)
        ->fetch();
    }
    /**
     * 添加
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'Category');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);
            if ($category= CategoryModel::create($data)) {
                // 记录行为
                action_log('catgory_add', 'book', $category['id'], UID);
                $this->success('新增成功', url('index'));
            } else {
                $this->error('新增失败');
            }
        }
        $list = CategoryModel::getMenuTree();
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
        ->setPageTitle('新增') // 设置页面标题
        ->addFormItems([ // 批量添加表单项
            ['text', 'name', '分类名称', '必填'],
            ['select','pid','所属分类', '', $list],
            ['radio', 'status', '状态', '', ['禁用', '启用'], 1]
        ])
        ->fetch();
    }
}

?>