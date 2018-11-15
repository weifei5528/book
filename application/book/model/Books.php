<?php
namespace app\book\model;

use think\Model;
class Books extends Model
{
    protected  $autoWriteTimestamp = true;
    public static function getType($id)
    {
        return self::where(['id' => $id])->value('type');
    }
}

?>