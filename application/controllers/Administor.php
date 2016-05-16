<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-5-4
 * Time: 下午6:50
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Administor extends MY_Controller{
    //修改密码界面
    public function change(){
        $this->load->view('admin/password.html');

    }
    //执行修改密码动作
    public function change_password(){
        //接受原密码与修改后的密码
        $password=$this->input->post('password');
        $passworda=$this->input->post('passworda');
        $passwordb=$this->input->post('passwordb');

        $this->load->model('Admin_model','admin');
        $data=$this->admin->check_admin($this->session->userData('username'));
        if($data[0]['password']!=$password)
        {
            error('原密码输入错误');
        }

        if($passworda!=$passwordb)
        {
            error('两次密码输入不一致');
        }
        $data=array(
            'password'=>$passworda
        );


        $uid=$this->session->userData('uid');
        $this->admin->update_password($uid,$data);
        success('Admin/copy','修改成功');


    }

    //退出界面
    public function login_out(){
        session_destroy();
        success('Login/index','退出成功');

    }

}