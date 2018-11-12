<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/12
 * Time: 20:34
 */

namespace app\book\validate;


use think\Validate;

class Users extends  Validate
{

    //定义验证规则
    protected $rule = [
        'name|图书名称' => 'require',
        'img |图书图片'   => 'require|number',
        'cat_id|分类'  => 'require|number',

    ];

    //定义验证提示
    protected $message = [
        'img.number' => '图书图片不正确',
        'cat_id.number'=> '分类格式不正确'
    ];
}