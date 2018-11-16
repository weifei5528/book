<?php
namespace app\book\validate;

use think\Validate;
class BookAudios extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|音频名称' => 'require',
        'audio|音频文件'   => 'require|number',
        'book_id|图书'  => 'require|number',
    
    ];
    
    //定义验证提示
    protected $message = [
        'audio.number' => '音频文件不正确',
        'book_id.number'=> '图书ID不存在'
    ];
}

?>