<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++)
        {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        $this->view->assign([
            'totaldevs'        => db('mp_dev')->count(),
            'totalpass'       => db('mp_dev')->where("status='normal'")->count(),
            'totalerrs'       => db('mp_dev')->where("status='deleted'")->count(),
            'totalrecordcount' => db('mp_record')->count(),
            'todaydevs'   => db('mp_dev')->whereTime('createtime', 'today')->count(),
            'todayerrs'  => db('mp_dev')->where("status='deleted'")->whereTime('createtime', 'today')->count(),
            'todaypass'       => db('mp_dev')->where("status='normal'")->whereTime('createtime', 'today')->count(),
            'todayrecords'    => db('mp_record')->whereTime('createtime', 'today')->count(),
            'sevendevs'         => db('mp_dev')->whereTime('createtime', 'week')->count(),
            'sevenrecords'         => db('mp_record')->whereTime('createtime', 'week')->count(),
            'zpdudevs'        => db('mp_dev')->where("devtype='ZPDU'")->count(),
            'zpdupass'        => db('mp_dev')->where("devtype='ZPDU'")->where("status='normal'")->count(),
            'mpdudevs'        => db('mp_dev')->where("devtype='MPDU'")->count(),
            'mpdupass'        => db('mp_dev')->where("devtype='MPDU'")->where("status='normal'")->count(),
            'ippdudevs'        => db('mp_dev')->where("devtype='IP-PDU'")->count(),
            'ippdupass'        => db('mp_dev')->where("devtype='IP-PDU'")->where("status='normal'")->count(),
            'sipdudevs'        => db('mp_dev')->where("devtype='SI-PDU'")->count(),
            'sipdupass'        => db('mp_dev')->where("devtype='SI-PDU'")->where("status='normal'")->count(),

            'paylist'          => $paylist,
            'createlist'       => $createlist,
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode
        ]);

        return $this->view->fetch();
    }

}
