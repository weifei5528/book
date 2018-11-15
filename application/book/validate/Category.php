<?php
namespace app\book\validate;

use think\Validate;
class Category extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|分类名称' => 'require',
    
    ];
    
    
}

?>