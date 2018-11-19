<?php

namespace app\admin\model\mp;

use think\Model;

class Dev extends Model
{
    // 表名
    protected $name = 'mp_dev';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'devtype_text',
        'status_text'
    ];
    

    
    public function getDevtypeList()
    {
        return ['M-PDU' => __('M-pdu'),'Z-PDU' => __('Z-pdu'),'IP-PDU' => __('Ip-pdu'),'SI-PDU' => __('Si-pdu')];
    }     

    public function getStatusList()
    {
        return ['normal' => __('Normal'),'deleted' => __('Deleted')];
    }     


    public function getDevtypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['devtype']) ? $data['devtype'] : '');
        $list = $this->getDevtypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
