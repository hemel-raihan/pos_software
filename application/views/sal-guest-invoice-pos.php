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

	// $q=$this->db->query("select * from db_salespayments where sales_id=$sales_id");
    // $res=$q->row();
	// $payment_type = $res->payment_type;
	// $change_return = $res->change_return;
	// $total_paying = $res->total_paying;
	
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

  	$q3=$this->db->query("SELECT a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.reference_no,
                           b.id,b.sales_note, b.order_type,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.created_by

                           FROM db_customers a,
                           db_hold b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$hold_id' 
                           ");
                           /*GROUP BY 
                           b.`customer_code`*/
    
    $res3=$q3->row();
	$today = date("Y-m-d h:i a");
	$print_date=date("d-m-Y h:i a",strtotime($today));

	// $q5=$this->db->query("select * from db_users where id=$res3->waiter_id ");

    // $res5=$q5->row();	
	// $waiter_name=$res5->username;

	$order_type = $res3->order_type;
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
				<span>									 
                <!-- <strong><span style="font-size:25px"><?= $company_name; ?></span></strong><br> -->
				<img class='img-responsive' width="100px"  src="<?php echo $base_url; ?>/uploads/company/<?= $company_logo;?>">
                	<?php echo (!empty(trim($company_address))) ? $this->lang->line('company_address')."".$company_address."<br>" : '';?> 
		            <?= $company_city; ?>
		            <?php echo (!empty(trim($company_postcode))) ? "-".$company_postcode : '';?>
		            <br>
		            <?php echo (!empty(trim($company_gst_no))) ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
		            <!-- <?php echo (!empty(trim($company_vat_number))) ? $this->lang->line('vat_number').": ".$company_vat_number."<br>" : '';?> -->
		            <?php if(!empty(trim($company_mobile))) 
		            		{ 
		            			echo $this->lang->line('phone').": ".$company_mobile;
		            			if(!empty($company_phone)){
		            				echo ",".$company_phone;
		            			}
		            			echo "<br>";
		            		}

		            ?> 
			</span>
            
			
		<h3><b>	Token No: <?php echo $hold_id; ?></b></h3>
        Guest Bill </br>
		<?php echo (!empty(trim($company_vat_number))) ? $company_vat_number."<br>" : '';?>
		Wifi Password: <?= $wifi_pass; ?>  </br>
		Order Time: <?= $sales_date." ".$created_time; ?>  </br>
		Print Time: <?= $print_date ?>  </br>
		Cashier Name: <?= ucfirst($seller_name); ?>  </br>
		Waiter Name: <?= $waiter_name; ?>
			</td>
		</tr>
		<!-- <tr><td align="center"><strong>-----------------<?= $this->lang->line('invoice'); ?>-----------------</strong></td></tr> -->
		<tr><td align="center"><strong>-----------------Order Information-----------------</strong></td></tr>
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
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">#</th>
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('description'); ?></th>
						<th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('price'); ?></th>
						<th style="font-size: 11px; text-align: center;padding-left: 2px; padding-right: 2px;">Qty</th>
				<!--		<th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('discount'); ?></th>  -->
						<th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;"><?= $this->lang->line('total'); ?></th>
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
			              //$q2=$this->db->query("select b.sales_price, b.tax_id, a.discount_type,a.discount_input,a.discount_amt, b.item_name, b.gov_sd, a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,a.gov_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id'");
						  $q2=$this->db->query("select b.sales_price, b.tax_id, a.discount_type,a.discount_input,a.discount_amt, b.item_name, b.gov_sd, a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,a.gov_amt,c.tax,a.total_cost from db_holditems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.hold_id='$hold_id'");
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
			                  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$res2->price_per_unit."</td>";
			                  echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>".$res2->sales_qty."</td>";
			               //   echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;'>".number_format(($res2->discount_amt),2,'.','')."</td>";
			                  echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;' >".number_format(($total_with_qty),2,'.','')."</td>";
			                  echo "</tr>";  
			                  //$tot_qty+=$res2->sales_qty;
			                 
			              }
			              
			              ?>
					
				   </tbody>
					<tfoot>
					 <!-- <tr><td colspan="5"><hr></td></tr>    -->
					 <tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right">Total</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($before_tax),2,'.','');?></td>
					</tr>
					<tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right">VAT(<?= $vat ?>%)</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($tax_amt),2,'.','');?></td>
					</tr>
					<tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right">delivery Charge</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($other_charges_amt),2,'.','');?></td>
					</tr>
					<!-- <tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right"><?= $this->lang->line('subtotal'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($subtotal),2,'.','');?></td>
					</tr> -->
					<!-- <tr>
	                     <td style=' padding-left: 2px; padding-right: 2px;' colspan='4' align='right'>Tax Amt</td>
	                      <td style=' padding-left: 2px; padding-right: 2px;' align='right'><?= number_format(($tax_amt),2,'.','');?></td>
	                </tr> -->
	                <tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right">Gov SD(<?= $gov_sd_percant ?>%)</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($all_gov_sd),2,'.','');?></td>
					</tr>
	                <?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt!=0) {?>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right"><?= $this->lang->line('discount'); ?> <?= ($discount_to_all_type=='in_percentage') ? $discount_to_all_input .'%' : $discount_to_all_input.'[Fixed]' ;?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format(($tot_discount_to_all_amt),2,'.',''); ?></td>
					</tr>
					<?php } ?>
					

					<!-- <tr><td style="border-bottom-style: dashed;border-width: 0.1px;" colspan="5"></td></tr>   -->
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="4" align="right"><?= $this->lang->line('grand_total'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= $grand_total; ?></td>
					</tr>

					<!-- <tr>
						<td  colspan="2"  align="left">Payment Method : </td>
						<td  align="left"><?= $payment_type; ?></td>
					</tr>
					<?php if($total_paying != 0)
					{?>
						<tr>
							<td colspan="2"  align="left">Paid Amount : </td>
							<td  align="left"><?= number_format(($total_paying),2,'.',''); ?></td>
					    </tr>
					<?php }
					else
					{?>
						<tr>
						<td colspan="2"  align="left">Paid Amount : </td>
						<td  align="left"><?= number_format(($grand_total),2,'.',''); ?></td>
					</tr>
					<?php }
					 ?> 
					
					<tr>
						<td colspan="2"  align="left">Change Amount : </td>
						<td  align="left"><?= $change_return; ?></td>
					</tr> -->
				
					<tr>
						<td colspan="6" style=" padding-top: 10px;" align="center"><strong>----------WE SERVE HAPPINESS----------</strong></td>
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