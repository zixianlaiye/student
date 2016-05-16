<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-4-9
 * Time: 下午8:20
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller{
    public function index(){


        $this->load->view('admin/admin.html');
    }
//使用iframe
    public function copy(){

        $this->load->view('admin/copy.html');
    }


    //新增学生信息动作
    public function add(){
        $this->load->view('admin/add_student.html');
    }

    //新增学生信息数据库操作
    public function add_student(){

        $data=array(
            'name'=>$this->input->post('name'),
            'sex'=>$this->input->post('sex'),
            'number'=>$this->input->post('number'),
            'major'=>$this->input->post('major'),
            'time'=>$this->input->post('time'),
            'type'=>$this->input->post('type'),
            'class'=>$this->input->post('class'),
            'college'=>$this->input->post('college'),
        );

        $this->load->model('Admin_model','admin');

        $count=$this->admin->check($data['number']);
        if($count>=1)
        {error('此学号已注册过，请勿重复注册');}
        else{
        $this->admin->add_student($data);
        success('Admin/index','添加成功');
        }


    }

    //更新学生信息动作
    public function edit(){
       $this->load->view('admin/search2.html');//载入查询页面

    }
    //更新学生信息页面
    public function edit_student(){
        $number=$this->input->post('number');
        $this->load->model('Admin_model','admin');

        if($this->admin->check($number))
        {
            $data['student']=$this->admin->check_student($number);

            $this->load->view('admin/edit_student.html',$data);
        }
        else
        {
            error('此学号不存在，请重新输入');
        }


    }
    public function edit_action(){
        $uid=$this->input->post('uid');
        $data=array(
            'name'=>$this->input->post('name'),
            'sex'=>$this->input->post('sex'),
            'number'=>$this->input->post('number'),
            'major'=>$this->input->post('major'),
            'time'=>$this->input->post('time'),
            'type'=>$this->input->post('type'),
            'class'=>$this->input->post('class'),
            'college'=>$this->input->post('college'),

        );
        $this->load->model('Admin_model','admin');

        $count=$this->admin->check($data['number']);
        if($count>1)
        {error('输入的学号重复，请重新输入');}
        else
        {
        if($this->admin->change_student($uid,$data))
        {success('Admin/copy','更新成功');}
        }

    }


    //查询学生信息
    public function search(){

        $this->load->view('admin/search.html');

    }
    //查询学生信息并返回数据
    public function search_student(){
        $number=$this->input->post('number');
        $this->load->model('Admin_model','admin');

        if($this->admin->check($number))
        {
        $data['student']=$this->admin->check_student($number);

        $this->load->view('admin/show_student.html',$data);}
        else
        {error('此学号不存在，请重新输入');
        }
    }

    //查询全部学生信息
    public function show_all_student(){

        $this->load->library('pagination');
        $perPage=2;

        $config['base_url'] = site_url('Admin/show_all_student');
        $config['total_rows'] = $this->db->count_all_results('student');//统计文章数据个数
        $config['per_page'] = $perPage;

        $config['first_link']='第一页';
        $config['last_link']='最后一页';
        $config['prev_link']='上一页';
        $config['next_link']='下一页';


        $this->pagination->initialize($config);
        $data['links']= $this->pagination->create_links();

        $offset=$this->uri->segment(3);
        $this->db->limit($perPage,$offset);






        $this->load->model('Admin_model','admin');
        $data['student']=$this->admin->get_all_student();
        $this->load->view('admin/show_all.html',$data);



    }

    //删除学生信息
    public function Delete_student(){
        $uid=$this->input->post('uid');
        $this->load->model('Admin_model','admin');
        if($this->admin->del($uid))  //该函数成功执行返回0,不是1
        {
            success('Admin/index','删除失败请再试一次');
        }
        else
        {
            success('Admin/index','删除成功');
        }


    }



}