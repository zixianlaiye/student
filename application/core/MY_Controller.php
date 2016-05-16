<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-5-4
 * Time: 下午6:19
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $username=$this->session->userdata('username');
        $uid=$this->session->userdata('uid');

        //将非法访问者转入登录界面操作
        if(!$username||!$uid)
        {
            redirect('Login/index');
        }


    }

}
