<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<title><?= $page_title;?></title>
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
<style type="text/css">
	body{
		font-family: arial;
		font-size: 12px;
		/*font-weight: bold;*/
		padding-top:15px;
	}

	@media print {
        .no-print { display: none; }
    }
	@media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
</style>
</head>
<body onload="window.print();"><!--   -->
	<?php
	$CI =& get_instance();

	
	
    $q1=$this->db->query("select * from db_company where id=1 and status=1");
    $res1=$q1->row();
    $company_name		=$res1->company_name;
	$company_logo		=$res1->company_logo;
    $company_mobile		=$res1->mobile;
    $company_phone		=$res1->phone;
	$wifi_pass		=$res1->wifi_pass;
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)

	
	$q2_array = array();
	$category_id = $_GET['category_id'];
	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];
	$q2=$this->db->query("select * from db_items where category_id='$category_id'");

	$from_datee=date("Y-m-d",strtotime($from_date));
	$to_datee=date("Y-m-d",strtotime($to_date));
	foreach ($q2->result() as $res2) {
				$items_ids=$res2->id;
				array_push($q2_array,$items_ids);
			}
	//$names = array(90,124);
	
	$this->db->select("a.id,a.sales_code,a.sales_date,b.customer_name,b.customer_code,c.total_cost");
	$this->db->select("c.price_per_unit,c.item_id,d.item_name");
	
	$today = date("Y/m/d");
	// if($view_all=="no"){
	// 	$this->db->where("(a.sales_date>='$from_date' and a.sales_date<='$to_date')");
	// }
//		$this->db->group_by("c.`item_id`");
    $this->db->where("(a.sales_date>='$from_datee' and a.sales_date<='$to_datee')");
	$this->db->order_by("a.`sales_date`,a.sales_code",'asc');
	$this->db->group_by("d.`item_name`");
	$this->db->select_sum('c.sales_qty');
	$this->db->from("db_sales as a");
	$this->db->where("a.`id`= c.`sales_id`");
	$this->db->where("a.`sales_status`= 'Final'");
	$this->db->from("db_items as d");
	$this->db->where("d.`id`= c.`item_id`");
	$this->db->from("db_customers as b");
	$this->db->where("b.`id`= a.`customer_id`");
	$this->db->from("db_salesitems as c");
	
	if($category_id!=''){
		$this->db->where_in('c.item_id', $q2_array);
	}
	// elseif($item_id!='')
	// {
	// 	$this->db->where("c.item_id=$item_id");
	// }
	
	
	
	//echo $this->db->get_compiled_select();exit();
	
	// $q1=$this->db->get();
	// if($q1->num_rows()>0){
	// 	$i=0;
	// 	$tot_total_cost=0;
	// 	$tot_paid_amount=0;
	// 	$tot_due_amount=0;
	// 	foreach ($q1->result() as $res1) {
	// 		echo "<tr>";
	// 		echo "<td>".++$i."</td>";
	// 		echo "<td><a title='View Invoice' href='".base_url("sales/invoice/$res1->id")."'>".$res1->sales_code."</a></td>";
	// 		echo "<td>".show_date($res1->sales_date)."</td>";
	// 		echo "<td>".$res1->customer_name."</td>";
	// 		echo "<td>".$res1->item_name."</td>";
	// 		echo "<td>".$res1->sales_qty."</td>";
	// 		echo "<td class='text-right'>".app_number_format($res1->total_cost)."</td>";
			
	// 		echo "</tr>";
	// 		$tot_total_cost+=$res1->total_cost;
			
			
	// 	}
		
	// 	echo "<tr>
	// 			  <td class='text-right text-bold' colspan='6'><b>Total :</b></td>
	// 			  <td class='text-right text-bold'>".app_number_format($tot_total_cost)."</td>
	// 		  </tr>";
		
	// }
	// else{
	// 	echo "<tr>";
	// 	echo "<td class='text-center text-danger' colspan=13>No Records Found</td>";
	// 	echo "</tr>";
	// }
	
	// exit;

    
    ?>
	<table width="98%" align="center">
		<tr>
			<td align="center">
				<span>									 
                <!-- <strong><span style="font-size:25px"><?= $company_name; ?></span></strong><br> -->
				 <img class='img-responsive' width="100px"  src="<?php echo $base_url; ?>/uploads/company/<?= $company_logo;?>"> 
                	<?php echo (!empty(trim($company_address))) ? $this->lang->line('company_address')."".$company_address."<br>" : '';?> 
		            <?= $company_city; ?>
		            <?php echo (!empty(trim($company_postcode))) ? "-".$company_postcode : '';?>
		            <br>
		            <?php echo (!empty(trim($company_gst_no))) ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
		            <?php echo  $from_date. "  To  ".$to_date;?>
			     </span>
		
			</td>
		</tr>
		<!-- <tr><td align="center"><strong>-----------------<?= $this->lang->line('invoice'); ?>-----------------</strong></td></tr> -->
		<tr><td align="center"><strong>-----------------Item Details Summary-----------------</strong></td></tr>
		<tr>
			<td>
				<table width="100%">
	    	<!--	<tr>
						<td width="40%"><?= $this->lang->line('invoice'); ?></td>
						<td><b>#<?= $sales_code; ?></b></td>
					</tr> 
					<tr>
						<td><?= $this->lang->line('name'); ?></td>
						<td><?= $customer_name; ?></td>
					</tr>
					<tr>
						<td><?= $this->lang->line('seller'); ?></td>
						<td><?= ucfirst($seller_name); ?></td>
					</tr>  -->
					<!-- <tr>
						<td><?= $this->lang->line('date').":".$sales_date; ?></td>
						<td style="text-align: right;"><?= $this->lang->line('time').":".$created_time; ?></td>
					</tr> -->
				</table>
				
			</td>
		</tr>
		<tr>
			<td>

				<table width="100%" cellpadding="0" cellspacing="0"  >
					<thead>
					<tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('description'); ?></th>
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">Price</th>
						<th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('total'); ?></th>
					</tr>
					</thead>
					<tbody style="border-bottom-style: dashed;border-width: 0.1px;">
						<?php
			              
							
						  $q12=$this->db->get();
						  $res10=$q12->row(); 
						  if($q12->num_rows()>0){
						  	$i=0;
						  	$tot_total_cost=0;
							  $today = date("Y/m/d");
						  	$tot_paid_amount=0;
						  	$tot_due_amount=0;
						  	foreach ($q12->result() as $res12) {
								  $item_price = $res12->price_per_unit;
								$q13=$this->db->query("SELECT sales_qty FROM db_salesitems JOIN db_sales on db_sales.id = db_salesitems.sales_id WHERE sales_date >= '$from_datee' and sales_date <= '$to_datee' AND item_id='$res12->item_id';");
								
								

							    $qty = $res12->sales_qty;
								$sub_total = $item_price * $qty;
								
			                  echo "<tr>";  
			                  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$res12->item_name."</td>";
							  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$item_price." X ".$qty."</td>";
			                  echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;' >".app_number_format($sub_total)."</td>";
			                  echo "</tr>";  
			                 $tot_total_cost+=$sub_total;
								
							  }
							}
			              
			              ?>
					
				   </tbody>
					<tfoot>
					 <!-- <tr><td colspan="5"><hr></td></tr>    -->
					 <tr >
						<td colspan="2" align="left" >Grand Total</td>
						<td align="right" ><?= number_format(($tot_total_cost),2,'.','');?></td>
					</tr>
				
					<tr>
						<td colspan="6" style=" padding-top: 10px;" align="center"><strong>----------End Report----------</strong></td>
					</tr>

					<tr>
						<td colspan="6" align="center">
						
							<div style="display:inline-block;vertical-align:middle;line-height:16px !important;">	
								<img class="center-block" style=" width: 100%; opacity: 1.0">
							</div>
						
						</td>
					</tr>

					</tfoot>
				</table>
			</td>
		</tr>
	</table>
	<center >
  <div class="row no-print">
  <div class="col-md-12">
  <div class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4 form-group">
    <button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.print();" title="Print">Print</button>
    <?php if(isset($_GET['redirect'])){ ?>
		<a href="<?= base_url().$_GET['redirect'];?>"><button type="button" class="btn btn-block btn-danger btn-xs" title="Back">Back</button></a>
	<?php } ?>
   </div>
   </div>
   </div>
</center>
<p style="text-align: center;">Developed By: https://datahostbd.com/</p>



</body>
</html>