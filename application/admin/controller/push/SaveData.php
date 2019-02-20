<?php
/**
 * Created by PhpStorm.
 * User: luozhiyong
 * Date: 2018/11/20
 * Time: 11:28
 */

namespace app\admin\controller\push;

use app\admin\model\mp\Dev;
use app\admin\model\mp\Devinfo;
use app\admin\model\mp\Itemnum;
use app\admin\model\mp\Record;

class SaveData
{

    protected function devUut($data)
    {
        $ret = array_key_exists('dev_uut', $data);
        if($ret) {
            $mode = new Dev();
            $ret = $mode->data($data['dev_uut'])->save();
            if(!$ret) {
                $ret = json_encode([ 'code' => -3, 'msg'  => '设备保存失败：' . $mode->getError() ]);
            }  else {
                $ret = $mode->id;
            }
        }

        return $ret;
    }

    protected function devInfo($id, $data)
    {
        $ret = array_key_exists('dev_info', $data);
        if($ret) {
            $mode = new Devinfo();
            $mode->mp_dev_id = $id;
            $data['dev_info']['mp_dev_id'] = $id;
            $ret = $mode->data($data['dev_info'])->save();
            if(!$ret) {
                $ret = json_encode([ 'code' => -4, 'msg'  => '设备信息保存失败：' . $mode->getError() ]);
            }
        }

        return $ret;
    }

    protected function itemNum($id, $data)
    {
        $ret = array_key_exists('item_num', $data);
        if($ret) {
            $mode = new Itemnum();
            $mode->mp_dev_id = $id;
            $data['item_num']['mp_dev_id'] = $id;
            $ret = $mode->data($data['item_num'])->save();
            if(!$ret) {
                $ret = json_encode([ 'code' => -5, 'msg'  => '测试数量保存失败：' . $mode->getError() ]);
            }
        }

        return $ret;
    }

    protected function writeItem($id, $data)
    {
        $model = new Record();
        $model->mp_dev_id = $id;
        $data['mp_dev_id'] = $id;
        $ret = $model->data($data)->save();
        if(!$ret) {
            $ret = json_encode([ 'code' => -6, 'msg'  => '测试日志保存失败：' . $model->getError() ]);
        }
        return $ret;
    }


    protected function saveList($id, $list)
    {
        $ret = '';
        for($x=0;$x<count($list);$x++)
        {
            $ret = $this->writeItem($id, $list[$x]);
            if(1 !== $ret)  break;
        }

        return $ret;
    }



    /**
     * 接收数据入口方法
     * @param $json
     * @return Json数据
     */
    public function entryJson($json)
    {
        $data = json_decode($json, true);
        if(!is_null($data) && (false !== $data)) {
            return $this->version($data);
        } else {
            $result = [ 'code' => -1, 'msg'  => 'Json解析错误' ];
            return json_encode($result);
        }
    }

    protected function version($data)
    {
        $ret = $data['version'];
        if(2 === $ret) {
            $id = $ret = $this->devUut($data);
            if(strlen($ret) > 3)  return $ret;

            $ret = $this->devInfo($id,$data);
            if(strlen($ret) > 3)  return $ret;

            $ret = $this->itemNum($id, $data);
            if(strlen($ret) > 3)  return $ret;

            $ret = array_key_exists('item_list', $data);
            if($ret)  {
                $ret = $this->saveList($id,  $data['item_list']);
                if(strlen($ret) > 3)  return $ret;
            }

        } else {
            $ret = json_encode( [ 'code' => -2, 'msg'  => '版本号错误' ]);
        }


        return $ret;
    }

}