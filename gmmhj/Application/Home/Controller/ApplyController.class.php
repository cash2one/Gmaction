<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 申请
 */
class ApplyController extends BaseController {

  public function apply_list() {
    $where = array();
    $status = I('get.status');
    if($status == ''){
      $selected = 4;
      $status = 0;
    }else{
      $status = I('get.status');
      $selected = $status;
    }
    $where['status'] = $status;
        //申请列表
    $apply = D('Apply');
    $count = $apply->where($where)->count();
    $Page = new \Think\Page($count, 30);
    $show = $Page->show();
    $datas = $apply->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
    foreach($datas as &$r){
      $r['autoid'] = $this->getsid($r['autoid']) . '服';
    }
    $this->assign('datas', $datas);
    $this->assign('page', $show);
    $this->assign('status_list', array(array('id'=>0,'label'=>'未审核'),array('id'=>1,'label'=>'通过'),array('id'=>2,'label'=>'驳回')));
    $this->assign('status',$selected);
    $this->display();
  }

  public function rechargelist() {
    $where = array();
    $status = I('get.status');
    if($status == ''){
      $selected = 4;
      $status = 0;
    }else{
      $status = I('get.status');
      $selected = $status;
    }
    $where['status'] = $status;

        //申请列表
    $rechargeapply = D('Rechargeapply');
    $count = $rechargeapply->where($where)->count();
    $Page = new \Think\Page($count, 30);
    $show = $Page->show();
    $datas = $rechargeapply->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
    foreach($datas as &$r){
      $r['autoid'] = $this->getsid($r['autoid']) . '服';
    }
    $this->assign('datas', $datas);
    $this->assign('page', $show);
    $this->assign('status_list', array(array('id'=>0,'label'=>'未审核'),array('id'=>1,'label'=>'通过'),array('id'=>2,'label'=>'驳回')));
    $this->assign('status',$selected);
    $this->display();
  }

  public function proplist() {
    $where = array();
    $status = I('get.status');
    if($status == ''){
      $selected = 4;
      $status = 0;
    }else{
      $status = I('get.status');
      $selected = $status;
    }
    $where['status'] = $status;

        //申请列表
    $propapply = D('Propapply');
    $count = $propapply->where($where)->count();
    $Page = new \Think\Page($count, 30);
    $show = $Page->show();
    $datas = $propapply->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
    foreach($datas as &$r){
      $r['autoid'] = $this->getsid($r['autoid']) . '服';
    }
    $this->assign('datas', $datas);
    $this->assign('page', $show);
    $this->assign('status_list', array(array('id'=>0,'label'=>'未审核'),array('id'=>1,'label'=>'通过'),array('id'=>2,'label'=>'驳回')));
    $this->assign('status',$selected);
    $this->display();
  }

  public function review() {
    $input = I('post.');


    if (!empty($input)) {
     $apply = D('Apply');
     $reviews = I('post.review');
     $reason = I('post.reason');
     foreach($reviews as $id => $check) {

      $status = $check == 1 ? 1 : 2;
      $tmp = array(
       'review_reason' => $reason,
       'status' => $status,
       'review_time' => time(),
       );

      if($check == 1) {
        $tempchar = array();
       $info = $apply->where(array('id' => $id))->find();
       $characters = explode(',',$info['characters']);
       foreach($characters as $character){
        $temp = $this->getuserid($character,$info['autoid']);
        if($temp){
          $tempchar[] = $temp;
        }else{
          break;
        }
      }
      if($tempchar == ''){
        $this->error('查找不到该用户信息');
      }
	  $tmp['characterid'] = $temp;
      $info['characters'] = implode(",",$tempchar);
      $data = array(
        'character_num'	=> count($characters),
        'characterids' => $info['characters'],
        'sid' => $this->getsid($info['autoid']),
        'emoney' => $info['apply_gold'],
        'content' => $info['content']
        );
	  $tmp['characterid'] = $data['characterids'];
      $this->send_msg('GMMail',$data,$info['autoid']);
      $this->log('审核id为' . $info['characters'] . '的元宝申请',cookie('gmuser'));
    }
    $apply->where(array('id' => $id))->save($tmp);
  }
  $this->success('处理成功', U('Apply/apply_list'));
}else{

}
}

public function rechargereview() {
  $input = I('post.');


  if (!empty($input)) {
   $rechargeapply = D('Rechargeapply');
   $reviews = I('post.review');
   $reason = I('post.reason');
   foreach($reviews as $id => $check) {
    $status = $check == 1 ? 1 : 2;
    $tmp = array(
     'review_reason' => $reason,
     'status' => $status,
     'review_time' => time(),
     );
    

    if($check == 1) {
     $info = $rechargeapply->where(array('id' => $id))->find();
     $temp = $this->getuserid($info['characters'],$info['autoid']);
     if($temp){
      $info['characters'] = $temp;
    }else{
      $this->error('查找不到该用户信息');
    }
    $data = array(
      'sid'           =>  $this->getsid($info['autoid']),
      'characterid'   =>  $info['characters'],
      'money'         =>  $info['apply_gold']
      );
    //var_dump($data);exit;
    $this->send_msg('Recharge',$data,$info['autoid']);
    $this->log('审核id为' . $info['characters'] . '的充值申请',cookie('gmuser'));
  }else{
    $this->log('驳回id为' . $info['characters'] . '的充值申请',cookie('gmuser'));
  }
  $rechargeapply->where(array('id' => $id))->save($tmp);
}
$this->success('处理成功', U('Apply/rechargelist'));
}else{

}
}

public function propreview() {
  $input = I('post.');


  if (!empty($input)) {
   $propapply = D('Propapply');
   $reviews = I('post.review');
   $reason = I('post.reason');
   //var_dump($reviews);exit;
   foreach($reviews as $id => $check) {

    $status = $check == 1 ? 1 : 2;
    $tmp = array(
     'review_reason'  => $reason,
     'status'         => $status,
     'review_time'    => time(),
     );
    

    if($check == 1) {
      $tempchar = array();
     $info = $propapply->where(array('id' => $id))->find();
     $characters = explode(',',$info['characters']);
     foreach($characters as $character){
      $temp = $this->getuserid($character,$info['autoid']);
      if($temp){
        $tempchar[] = $temp;
      }
    }
    if($tempchar == ''){
      $this->error('查找不到该用户信息');
    }
    $info['characters'] = implode(",",$tempchar);
    $data = array(
      'character_num' =>  count($characters),
      'characterids'  =>  $info['characters'],
      'sid'           =>  $this->getsid($info['autoid']),
      'content'       =>  $info['content'],
      'itemid'        =>  $info['propid'],
      'num'           =>  $info['propnum'],
      'isbind'        =>  $info['isbind'] == 0 ? true : false,
      'money'         =>  0,
      'emoney'        =>  0                  
      );
    var_dump($data);
    echo "<hr>";
    $ret = $this->send_msg('GMMail',$data,$info['autoid']);
    if($ret['ret'] == 0){
      $propapply->where(array('id' => $id))->save($tmp);
      $this->log('审核id为' . $info['characters'] . '的道具申请',cookie('gmuser'));
      $this->success('处理成功',U('Apply/proplist'));
    }
  }else{
    $propapply->where(array('id' => $id))->save($tmp);
    $this->log('审核id为' . $info['characters'] . '的道具申请',cookie('gmuser'));
    $this->success('驳回成功',U('Apply/proplist'));
  }
}
       //$this->success('处理成功', U('Apply/apply_list'));
}else{

}
}

    /**
     * 选择区服，输入角色名（”添加“的按钮，”添加10个“的按钮，是否添加为内部号的勾选框）  ，在数据输入框填写：申请数量  申请原因：必填													
     */
    public function apply() {

      $input = I('post.');
      if (!empty($input)) {
        $sid = I('post.autoid');
        $characters = I('post.characters');
        $reason = I('post.reason');
        $apply_gold = (int) I('post.apply_gold');
        $data = array(
          'autoid' => $sid,
          'characters' => $characters,
          'apply_reason' => $reason,
          'apply_time' => date('Y-m-d H:i:s'),
          'status' => 0,
          'apply_gold' => $apply_gold,
          );
        $apply = D('Apply');
        if ($apply->add($data)) {
                //成功，跳转
          $this->success('申请成功', U('Apply/apply_list'));
        } else {
          $this->error('申请失败');
        }
      }
      vendor('Pager.Pager');
      $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $sid));
      $this->display();
    }
    //申请元宝添加进申请表
    public function apply1(){
      $input = I('post.');
      $data = array(
        'characters'    =>  $input['characters'],
        'autoid'        =>  $input['autoid'],
        'apply_gold'    =>  $input['apply_gold'] ,
        'content'       =>  $input['apply_content'],
        'apply_reason'  =>  $input['reason'],
        'apply_time'    =>  time(),
        'status'        =>  0
        );
            //print_r($input);exit;
        //$ret = $this->send_msg('GMMail',$data,$input['autoid']);
        //$this->log($this->getsername($input['autoid']) . '服为id为' . $input['characters'] . '的用户申请' . $input['apply_gold'] . '元宝',cookie('gmuser'));
        //echo $ret['ret'];
    //print_r($data);exit;
      $apply = D('Apply');
      if($apply->add($data)){
        $this->log($this->getsername($input['autoid']) . '为id为' . $input['characters'] . '的用户申请' . $input['apply_gold'] . '元宝',cookie('gmuser'));
        echo 1;
      }else{
        echo $apply->getLastSql();
      }
    }

    //申请充值
    public function recharge(){
      vendor('Pager.Pager');
      $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $autoid));
      $this->display();
    }

    //申请充值操作
    public function setrecharge(){
      $input = I('post.');
      $data = array(
        'autoid'        =>  $input['autoid'],
        'characters'    =>  $input['characters'],
        'apply_gold'    =>  $input['money'],
        'apply_reason'  =>  $input['reason'],
        'apply_time'    =>  time(),
        'status'        =>  0    
        );
      $rechargeapply = D('Rechargeapply');
      if($rechargeapply->add($data)){
        $this->log($this->getsername($input['autoid']) . '为id为' . $input['characters'] . '的用户申请' . $input['money'] . '充值',cookie('gmuser'));
        $this->success('申请成功！',U('Apply/recharge'));
      }else{
        $this->error($rechargeapply->getLastSql());
      }
    /*$ret = $this->send_msg('Recharge',$data,$input['autoid']);
    if($ret['ret'] == 0){
        //$this->log($this->getsername($input['autoid']) . '服为id为' . $input['characters'] . '的用户申请' . $input['money'] . '充值',cookie('gmuser'));
        echo "充值成功！";
    }else{
        echo "充值失败！";
      }*/
    }
    //全服发元宝
    public function serverapply(){
      vendor('Pager.Pager');
      $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $sid));
      $this->display();
    }

    //全服发元宝
    public function allserver(){
      $input = I('post.');
      $data = array(
        'character_num' =>  0,
        'sid'           =>  $this->getsid($input['autoid']),
        'money'         =>  0,
        'emoney'        =>  $input['apply_gold'],
        'content'       =>  $input['apply_content']
        );
        //print_r($input);exit;
      $ret = $this->send_msg('GMMail',$data,$input['autoid']);
      $this->log($this->getsername($input['autoid']) . '全服发放' . $input['apply_gold'] . '元宝',cookie('gmuser'));
      echo $ret['ret'];
    }

    //全服发礼金
    public function cashgift(){
      vendor('Pager.Pager');
      $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $sid));
      $this->display();
    }


    //全服发礼金
    public function sendcashgift(){
      $input = I('post.');
      $data = array(
        'character_num' =>  0,
        'sid'           =>  $this->getsid($input['autoid']),
        'money'         =>  0,
        'emoney'        =>  0,
        'content'       =>  $input['apply_content'],
        'itemid'        =>  108701,
        'num'           =>  $input['apply_gold'],
        'isbind'        =>  true
        );
        //print_r($input);exit;
      $ret = $this->send_msg('GMMail',$data,$input['autoid']);
      //$this->log($this->getsername($input['autoid']) . '全服发放' . $input['apply_gold'] . '元宝',cookie('gmuser'));
      echo $ret['ret'];
    }


//道具申请
    public function prop(){
      vendor('Pager.Pager');
      $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $sid));
      $this->assign('props',$this->getprop());
      $this->display();
    }

//道具申请入库
    public function setprop(){
      $input = I('post.');
      $input['apply_time'] = time();
      $input['status'] = 0;
      $propapply = D('Propapply');
      if($propapply->add($input)){
        echo 1;
        if(cookie('gmuser') == 'jishu'){

        }else{
          $this->log($this->getsername($input['autoid']) . '为id为' . $input['characters'] . '的用户申请道具' . $input['propname'],cookie('gmuser'));
        }
      }else{
        echo $propapply->getLastSql();
      }
    }

    public function apply2(){
      $data = array(
        'character_num' =>  1,
        'characterids'  =>  1706,
        'sid'           =>  1,
        'content'       =>  '222222',
        'itemid'        =>  108106,
        'num'           =>  1,
        'isbind'        =>  0,
        'money'         =>  5000,
        'emoney'        =>  5000                  
        );
      $ret = $this->send_msg('GMMail',$data,25);
	  echo $data['characterids'];
      print_r($ret);
    }
    public function apply3(){
      $data = array(
        'sid'           =>  1,
        'characterid'   =>  5407,
        'money'         =>  500
        );
      $ret = $this->send_msg('Recharge',$data,25);
      print_r($ret);//47,1808
    }

    //根据用户信息查找用户id
    public function getuserid($msg,$autoid){
      $character =  new \Home\Model\GSCharacterModel($autoid);
      if($ret = $character->where(array('account' => $msg))->find()){
        return $ret['characterid'];
      }
      if($ret = $character->where(array('name' => $msg))->find()){
        return $ret['characterid'];
      }
      if($ret = $character->where(array('characterid' => $msg))->find()){
        return $msg;
      }
      return false;
    }

    public function lotapply(){
        //批量申请
        vendor('Pager.Pager');
        $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $sid));
        $this->assign('props',$this->getprop());
        $this->display();
    }

    public function sendlot(){
        //发送批量申请
        $input = I('post.');
        $characterarr = explode(',',$input['characters']);
        $data['character_num'] = count($characterarr);
        if($data['character_num'] > 0){
            $tempchar = array();
            foreach($characterarr as $singlech){
               $tempchar[] = $this->getuserid($singlech,$input['autoid']); 
            }
            $data['characterids'] = implode(',',$tempchar);
        }
        $data['sid'] = $this->getsid($input['autoid']);
        $data['content'] = $input['content'];
        $data['money'] = $input['money'];
        $data['emoney'] = $input['emoney'];
        $proparr = explode(',',$input['props']);
        foreach($proparr as $arr){
            $temp = explode(':',$arr);
            $mailthing[] = array(
                'itemid'    =>  $temp[0],
                'num'       =>  $temp[1],
                'isbind'    =>  $temp[2]
            );
        }
        $data['mailthing'] = $mailthing;
        $ret = $this->send_msg('GMMail1',$data,$input['autoid']);
        $this->log($this->getsername($input['autoid']) . '为id为' . $input['characters'] . '的用户批量申请',cookie('gmuser'));
        echo $ret['ret'];
    }

    //批量邮件
    public function sendmails(){
        $input = I('post.');
        $autoid = $input['autoid'];
        $start_date = $input['start_date'];
        $end_date = $input['end_date'];
        $viplevel = $input['viplevel'];
        $where = "where ";
        if(!empty($input)){
            if(empty($autoid)){
                $this->error('请选择区服');
            }
            if(!empty($start_date) && !empty($end_date)){
                $this->assign('start_date',$start_date);
                $this->assign('end_date',$end_date);
                $where .= "time between '{$start_date}' and '{$end_date} 23:59:59' ";
                $havedate = true;
            }else{
                $havedate = false;
            }
            if(!empty($viplevel)){
                $this->assign('viplevel',$viplevel);
                if($havedate){
                    $where .= "and vip={$viplevel} ";
                }else{
                    $where .= "vip={$viplevel} ";
                }
            }
            $sql = "select * from (select * from `vip` {$where}order by time desc) t group by characterid;";
            $emptydata = new \Home\Model\OAEmptyModel($autoid); 
            $rs = $emptydata->query($sql);
            $this->assign('rs',$rs);
        }
        vendor('Pager.Pager');
        $this->assign('server_html', \Pager::getSelect('autoid', 'autoid', $this->_server, $autoid));
        $this->display();
    }

    //批量发送邮件
    public function mailstart(){
        $input = I('post.');
        $data = array(
            "character_num" =>  1,
            "characterids"  =>  $input['character'],
            "sid"           =>  $this->getsid($input['autoid']),
            "emoney"        =>  0,
            "content"       =>  $input['content']
        );
        $ret = $this->send_msg("GMMail",$data,$input['autoid']);
        echo $ret['ret'];
    }
  }
