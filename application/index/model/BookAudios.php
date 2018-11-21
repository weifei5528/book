<?php
namespace app\index\model;

use think\Model;
class BookAudios extends Model
{
    /**
     * 获取指定图书的音频列表
     * @param int $id 图书的id
     */
    public static function getList($id)
    {
        return self::where(['book_id' => $id, 'status' => 1])->order(['click' => 'desc'])->paginate();
    }
    /**
     * 获取音频的原始地址
     */
    public static function getOriginalAddr($id)
    {
        return self::where(['id' => $id])->value('audio_url');
    }
}

?>