<?php

namespace app\admin\model\mp;

use think\Model;

class Record extends Model
{
    // 表名
    protected $name = 'mp_record';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    
    public function getStatusList()
    {
        return ['normal' => __('Normal'),'deleted' => __('Deleted')];
    }     


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function dev()
    {
        return $this->belongsTo('Dev', 'mp_dev_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
