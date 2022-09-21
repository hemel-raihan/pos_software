<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('sd_model','sd');
	}
	
	public function index(){
		$this->permission_check('tax_view');
		$data=$this->data;
		$data['page_title']='SD List';
		$this->load->view('sd-list', $data);
	}
	//ITS FROM POP UP MODAL
    public function add_sd_modal(){

      $this->form_validation->set_rules('sd_name', 'sd Name', 'trim|required');
      $this->form_validation->set_rules('sd', 'sd Name', 'trim|required');
      if ($this->form_validation->run() == TRUE) {
        
        $result=$this->tax->verify_and_save();
        //fetch latest item details
        $res=array();
        $query=$this->db->query("select id,sd_name,sd from db_sd order by id desc limit 1");
        $res['id']=$query->row()->id;
        $res['sd_name']=$query->row()->sd_name;
        $res['sd']=$query->row()->sd;
        $res['result']=$result;
        
        echo json_encode($res);

      } 
      else {
        echo "Please Fill Compulsory(* marked) Fields.";
      }
    }
    //END

	public function newsd(){
		$this->form_validation->set_rules('sd_name', 'sd Name', 'trim|required');
		$this->form_validation->set_rules('sd', 'sd Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->tax->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Tax Name & Tax Percentage!";
		}
	}
	public function update($id){
		$this->permission_check('tax_edit');
		$result=$this->tax->get_details($id);
		$data=array_merge($this->data,$result);
		$data['page_title']="SD Update";
		$this->load->view('sd', $data);
	}
	public function update_sd(){
		$this->form_validation->set_rules('sd_name', 'sd Name', 'trim|required');
		$this->form_validation->set_rules('sd', 'sd', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->tax->update_sd();
			echo $result;
		} else {
			echo "Please Enter SD Name & SD Percentage!";
		}
	}
	public function add(){
		$this->permission_check('sd_add');
		$data=$this->data;
		$data['page_title']='New SD';
		$this->load->view('sd
        ', $data);
	}

	public function ajax_list()
	{
		$list = $this->sd->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sd) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$sd->id.' class="checkbox column_checkbox" >';
			$row[] = $sd->sd_name;
			$row[] = $sd->sd;
			

			 		if($sd->status==1){ 
			 			$str= "<span onclick='update_status(".$sd->id.",0)' id='span_".$sd->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$sd->id.",1)' id='span_".$sd->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
			         $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('tax_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="sd/update/'.$sd->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('tax_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_sd('.$sd->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';		
			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sd->count_all(),
						"recordsFiltered" => $this->sd->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('tax_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->tax->update_status($id,$status);
		return $result;
	}
	
	public function delete_sd(){
		$this->permission_check_with_msg('tax_delete');
		$id=$this->input->post('q_id');
		return $this->tax->delete_sd_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('tax_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->tax->delete_sd_from_table($ids);
	}

}

