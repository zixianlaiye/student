<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-4-3
 * Time: 下午8:48
 */

class Admin_model extends CI_Model{
    //查询用户信息
    public function check_admin($username){
        $data=$this->db->get_where('admin',array('username'=>$username))->result_array();
        return $data;
    }

    //管理员修改密码
    public function update_password($uid,$data){
        $this->db->update('admin',$data,array('uid'=>$uid));


    }




    //增加学生信息
    public function add_student($data){
        $this->db->insert('student',$data);
    }

    //检验学生信息是否存在
    public function check($number){
        $query=$this->db->get_where('student',array('number'=>$number));
        $data=$query->num_rows();

        return $data;
    }

    //查询学生信息
    public function check_student($number){

        $data=$this->db->get_where('student',array('number'=>$number))->result_array();
        return $data;

    }

    //修改学生信息
    public function change_student($uid,$data){
        $this->db->update('student',$data,array('uid'=>$uid));

    }
    //删除学生信息
    public function del($uid){
        $this->db->delete('student',array('uid'=>$uid));

    }
    //查询全部学生信息
    public function get_all_student(){
        $data= $this->db->get('student')->result_array();
        return $data;

    }


}

