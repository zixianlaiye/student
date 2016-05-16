<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-4-3
 * Time: 下午8:44
 */


class Login extends CI_Controller{


    public function index(){
        if(!isset($_SESSION))
        {session_start();}

        $this->load->helper('captcha');
        //验证码配置
        $speed = 'abcdefghijklmnopqrstuvwxyz1234567890';

        $word='';
        for($i=0;$i<4;$i++)
        {
            $word.=$speed[mt_rand(0,strlen($speed))-1];
        }

        $vals = array(
            'word' => $word,
            'img_path' => './captcha/',
            'img_url' => base_url() . '/captcha/',
            'img_width' => 100,
            'img_height' => 40,
            'expiration' => 7200,
            'font_size' => 21,
            'font_path' =>  './system/fonts/GB18030.ttf',
        );
        //创建验证码
        $cap = create_captcha($vals);

        //$cap['filename'];验证码图片名称


        $_SESSION['code']=$cap['word'];
//        p($cap);
//        echo $_SESSION['code'];
//        die;
        $data['captcha'] = $cap['image'];
        $this->load->view('index/login.html',$data);
    }



    //登录验证
    public function check(){
        if(!isset($_SESSION)){
            session_start();
        }

        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $cap=$this->input->post('identifyingCode');

//        echo $cap;
//        echo $_SESSION['code'];
//        die;

//        if($cap!=$_SESSION['code'])
//        {
//            error('验证码输入错误');
//        }


        $this->load->model('Admin_model','admin');
        $data=$this->admin->check_admin($username);




        if($data[0]['password']==$password)
        {
            $sessionData=array(
                'username'=>$username,
                'uid'=> $data[0]['uid'],
                'logintime'=>time()
            );
            $this->session->set_userdata($sessionData);



            success('Admin/index','登录成功');
        }
        else {
            error('用户名或密码错误');
        }
    }

    //退出登录
    public function login_out(){
        $this->session->sess_destory();
        success('Login/index','退出成功');
    }
}