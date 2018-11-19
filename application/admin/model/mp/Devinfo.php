<?php

namespace app\admin\model\mp;

use think\Model;

class Devinfo extends Model
{
    // 表名
    protected $name = 'mp_devinfo';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function dev()
    {
        return $this->belongsTo('Dev', 'mp_dev_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
