<?php
if(!defined("__XE__")) exit();
/**
    * @file document_write_ip_filter.addon.php
    * @biref Limits the permissions of writing according to the ip values.
    * @author gmail (ghana369@gmail.com)
 */
if($called_position !== 'before_module_proc') return;

// mid
$mids = array(
    'board',
    'document'
);

//mid 확인
if(!in_array($this->module, $mids)) return;

// logged_info 가져오기
$logged_info = Context::get('logged_info');

//관리자는 패스
if($logged_info->is_admin == 'Y') return;

// 회원 아이피 가져오기
$ip = $logged_info->ip;

// ip 없을 때
if(!$ip)
{
    $this->act = null;
    $this->stop($addon_info->msg_ip);    
}  

// 허용할 ip들 
$user_ip = $addon_info->user_ip;
$ip_array = array_map('trim',explode('/',$user_ip));

//ip 값 비교
if(in_array($ip, $ip_array)) return;

// act
$acts = array(
    'dispBoardWrite',
    'procBoardInsertDocument',
    'dispTempSavedList',
    'procDocumentTempSave',
);

// act 블럭
if(!in_array($this->act, $acts)) return;
$this->act = null;
$this->stop($addon_info->msg);  


    /* 삽질 2 */    
    // $logged_info = Context::get('logged_info');
    // $agrs->member_srl = $logged_info->member_srl;
    // $agrs->group_srl = 465;
    // $ip = $logged_info->ip;
    // var_dump($agrs);
    // var_dump($ip);
    // var_dump($addon_info->user_ip);
    // if($ip !== $addon_info->user_ip){
    //     Context::addJsFile('./addons/ip_filter/ip_filter.js');
    //     $output=executeQueryArray('addons.ip_filter.updateIpGroup',$agrs);
    //     var_dump($output);
    // }

