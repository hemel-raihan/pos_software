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
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)

				   

  	$q3=$this->db->query("SELECT a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note, b.waiter_id,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status,
                           b.created_by

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                           /*GROUP BY 
                           b.`customer_code`*/
		
						   
    
    $res3=$q3->row();

	$q5=$this->db->query("select * from db_users where id=$res3->waiter_id ");

    $res5=$q5->row();	
	$waiter_name=$res5->username;


    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=show_date($res3->sales_date);
    $reference_no=$res3->reference_no;
    $created_time=show_time($res3->created_time);
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $seller_name=$res3->created_by;

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    //$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    if($discount_to_all_input>0){
    	$str="($discount_to_all_input%)";
    }else{
    	$str="(Fixed)";
    }

    if(!empty($customer_country)){
      $customer_country = $this->db->query("select country from db_country where id='$customer_country'")->row()->country;  
    }
    if(!empty($customer_state)){
      $customer_state = $this->db->query("select state from db_states where id='$customer_state'")->row()->state;  
    }

    
    ?>
	<table width="98%" align="center">
		<tr>
			<td align="center">
			    
		<img class='img-responsive' width="150px"  src="<?php echo $base_url; ?>/uploads/company/<?= $company_logo;?>">
				
		<h2><b>	Token No: <?php echo $sales_id; ?></b></h2>
			</td>
		</tr>
		<!-- <tr><td align="center"><strong>-----------------<?= $this->lang->line('invoice'); ?>-----------------</strong></td></tr> -->
		<tr><td align="center"><strong>------------------KITCHEN PRINT: FOOD ITEM------------------</strong></td></tr>
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
			<table width="100%">
			    
	    	
					<tr>
						<td >ORDER DATE: <?= $sales_date; ?></td>	
					</tr>
					<tr>
					<td >ORDER TIME: <?= $created_time; ?></td>
					</tr>
				</table>
			</td>
		
		</tr>
		<tr><td align="center"><strong>-----------------------ORDER INFORMATION----------------------</strong></td></tr>
		<tr>
			<td>

				<table width="100%" cellpadding="0" cellspacing="0"  >
					<thead>
					<tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">#</th>
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">ITEM</th>
						<th style="font-size: 11px; text-align: center;padding-left: 2px; padding-right: 2px;">Qty</th>
					</tr>
					</thead>
					<tbody style="border-bottom-style: dashed;border-width: 0.1px;">
						<?php
			              $i=0;
			              $tot_qty=0;
			              $subtotal=0;
			              $tax_amt=0;
						  $all_gov_sd=0;
						  $sales_qty=0;
						  $gov_sd_percant = 0;
			              $q2=$this->db->query("select b.sales_price, b.tax_id, a.discount_type,a.discount_input,a.discount_amt, b.item_name, b.gov_sd, a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,a.gov_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id'");
						  $res10=$q2->row(); 
						  $gov_sd_percant +=  $res10->gov_sd;
						  $q11=$this->db->query("select * from db_tax where id=$res10->tax_id and status=1");
						  $res11=$q11->row();
						  $vat = $res11->tax;
						  foreach ($q2->result() as $res2) {
							
							$subtotal+=($res2->total_cost);
							$tax_amt+=$res2->tax_amt;
							$all_gov_sd+=$res2->gov_amt;
							$without_tax = $res2->sales_price;
							$before_tax = $subtotal-$tax_amt;
							$grandtot = $subtotal+$tax_amt+$other_charges_amt;
							$tot_qty = $res2->sales_qty;
							$total_with_qty = $res2->price_per_unit*$tot_qty;
							$asd = $res2->sales_price;
							$gov = $res2->gov_sd*$sales_qt;
							
							//$gov_sdpercent =($asd*$gov)/100;
							
							
			                  echo "<tr>";  
			                  echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'>".++$i."</td>";
			                  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$res2->item_name."</td>";
			                  echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>".$res2->sales_qty."</td>";
			                  echo "</tr>";  
			                  //$tot_qty+=$res2->sales_qty;
			                 
			              }
			              
			              ?>
					
				   </tbody>
					
				</table>
			</td>
		</tr>
	</table>
						</br>
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