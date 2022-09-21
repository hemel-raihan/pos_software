<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>
<body class="hold-transition skin-blue sidebar-mini">


<div class="wrapper">
 
 <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>
    <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Enter Valid Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <div class="box-body">
        <div class="form-group">
        <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                 
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y'));?>" readonly>
              
            </div>
            <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
          </div>
          <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                   <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="<?php echo show_date(date('d-m-Y'))?>" readonly>
              
            </div>
            <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
          </div>
        
                </div> 

          <div class="form-group">
          <label for="category_id" class="col-sm-2 control-label">Item Category</label>

                  <div class="col-sm-3">
          <select class="form-control select2 " id="category_id" name="category_id" >
          <option value="">-All-</option>
            <?php
            $q1=$this->db->query("select * from db_category where status=1");
             if($q1->num_rows()>0)
             {
                 foreach($q1->result() as $res1)
               {
                 echo "<option value='".$res1->id."'>".$res1->category_name."</option>";
               }
             }
             else
             {
                ?>
                <option value="">No Records Found</option>
                <?php
             }
            ?>
                  </select>
          <span id="category_id_msg" style="display:none" class="text-danger"></span>
                  </div>
          
          </div>

                <div class="form-group">
          <label for="item_id" class="col-sm-2 control-label"><?= $this->lang->line('item_name'); ?></label>

                  <div class="col-sm-3">
          <select class="form-control select2 " id="item_id" name="item_id" >
          <option value="">-All-</option>
            <?php
            $q1=$this->db->query("select * from db_items where status=1");
             if($q1->num_rows()>0)
             {
                 foreach($q1->result() as $res1)
               {
                 echo "<option value='".$res1->id."'>".$res1->item_name."</option>";
               }
             }
             else
             {
                ?>
                <option value="">No Records Found</option>
                <?php
             }
            ?>
                  </select>
          <span id="item_id_msg" style="display:none" class="text-danger"></span>
                  </div>
          
                </div>
              </div>
              <!-- /.box-body -->
        
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Show</button>
                   </div>
                   <div class="col-sm-3">
                    <a href="<?=base_url('dashboard');?>">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </a>
                   </div>
                </div>
             </div>
             <!-- /.box-footer -->

             
            </form>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= $this->lang->line('records_table'); ?></h3>
              <button type="button" class="btn btn-info pull-right btnExport" title="Download Data in Excel Format">Excel</button>
              <button type="button" title="Print the dailys sales report" style="margin-right: 20px;" class="btn btn-success pull-right" onclick="popup()">Print </button>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              
              <table class="table table-bordered table-hover " id="report-data" >
                <thead>
                <tr class="bg-blue">
                  <th style="">#</th>
                  <th style=""><?= $this->lang->line('invoice_no'); ?></th>
                  <th style=""><?= $this->lang->line('sales_date'); ?></th>
                  <th style=""><?= $this->lang->line('customer_name'); ?></th>
                  <th style=""><?= $this->lang->line('item_name'); ?></th>
                  <th style="">Price</th>
                  <th style="">Vat</th>
                  <th style="">SD</th>
                  <th style=""><?= $this->lang->line('item_sales_count'); ?></th>
                  <th style=""><?= $this->lang->line('sales_amount'); ?>(<?= $CI->currency(); ?>)</th>
                </tr>
                </thead>
                <tbody id="tbodyid">
                
              </tbody>
              </table>
              
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
  </div>

  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>

<script>
function popup(){
  var base_url=$("#base_url").val().trim();
  var from_date=document.getElementById("from_date").value.trim();
  var to_date=document.getElementById("to_date").value.trim();
  var category_id=document.getElementById("category_id").value.trim();
  var xhr = base_url+'reports/print_sales_report?category_id='+category_id+'&from_date='+from_date+'&to_date='+to_date;
  //var xhr = base_url+'reports/print_sales_report/'+category_id;
  popup=window.open(xhr,'print members', 'width=500,height=500');
  // $.ajax({
  //       type: 'POST',
  //       url: base_url+'reports/print_sales_report',
  //       data : {"category_id" : category_id, "from_date" : from_date, "to_date" : to_date},
  //       // cache: false,
  //       // contentType: false,
  //       // processData: false,
  //       success: function(result){
  //         console.log(result);
  //         $('#sku_combination').html(result);
          
  //        }
         
  //      });
};


function save(print=false,pay_all=false){

  //$('.make_sale').click(function (e) {
    
    var base_url=$("#base_url").val().trim();
      
      if($(".items_table tr").length==1){
        toastr["warning"]("Empty Sales List!!");
      return;
      }
  
  
    //RETRIVE ALL DYNAMIC HTML VALUES
      var tot_qty=$(".tot_qty").text();
      var tot_amt=$(".tot_amt").text();
      var tot_disc=$(".tot_disc").text();
      var tot_grand=$(".tot_grand").text();
      var paid_amt=(pay_all) ? tot_grand : $(".sales_div_tot_paid").text();
      var balance=(pay_all) ? 0 : parseFloat($(".sales_div_tot_balance").text());
  
     /* console.log("tot_grand="+tot_grand);
      console.log("balance="+balance);
      console.log("paid_amt="+paid_amt);
      return;*/
      if($("#customer_id").val().trim()==1 && balance!=0){
        toastr["warning"]("Walk-in Customer Should Pay Complete Amount!!");
      return;
      }
      if(document.getElementById("sales_id")){
        var command = 'update';
      }
      else{
        var command = 'save';
      }
      var this_btn='make_sale';
  
    //swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
        //  if(sure) {//confirmation start
  
      
      $("#"+this_btn).attr('disabled',true);  //Enable Save or Update button
      //e.preventDefault();
      var data = new Array(2);
      data= new FormData($('#pos-form')[0]);//form name
      /*Check XSS Code*/
      if(!xss_validation(data)){ return false; }
      
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $.ajax({
        type: 'POST',
        url: base_url+'pos/pos_save_update?command='+command+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&paid_amt="+paid_amt+'&balance='+balance+"&pay_all="+pay_all,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(result){
          //console.log(result);return;
          result=result.trim().split("<<<###>>>");
          console.log("result[0]"+result[0]);
          //return;
          if(result[0]){
            
            if(result[0]=="success")
            {
              var print_done=true;
              if(print){
                var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450");
              }
              if(print_done){
              
                if(command=='update'){
                  console.log("inside update");
                  window.location=base_url+"sales";		
                }
                else{
                  console.log("inside else");
                  success.currentTime = 0;
                  success.play();
                  toastr['success']("Invoice Saved Successfully!");
                  
                  //window.location=base_url+"pos";		
                  $(".items_table > tbody").empty();
                  $(".discount_input").val(0);
                  
                  $('#multiple-payments-modal').modal('hide');
                  var rc=$("#payment_row_count").val();
                  while(rc>1){
                    remove_row(rc);
                    rc--;
                  }
                  console.log('inside form');
                  $("#pos-form")[0].reset();
  
                  $("#customer_id").val(1).select2();
  
                  final_total();
                  //get_details();
                  //hold_invoice_list();
                  //window.location=base_url+"pos";
  
                }
                
              }
              
            }
            else if(result[0]=="failed")
            {
               toastr['error']("Sorry! Failed to save Record.Try again");
            }
            else
            {
              alert(result);
            }
          } // data.result end
          
          if(result[2]){
            $(".search_div").html('');
               $(".search_div").html(result[2]);	
          }
          if(result[3]){
              $("#hold_invoice_list").html('').html(result[3]);
              $(".hold_invoice_list_count").html('').html(result[4]);
          }
          
  
          $("."+this_btn).attr('disabled',false);  //Enable Save or Update button
          $(".overlay").remove();
          
         }
         
       });
      
    //} //confirmation sure
    //	}); //confirmation end
  
  //e.preventDefault
  
  
  //});
  }//Save End
</script>



<script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>
<script>
function convert_excel(type, fn, dl) {
    var elt = document.getElementById('report-data');
    var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
    return dl ?
        XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        XLSX.writeFile(wb, fn || ('Sales-Report.' + (type || 'xlsx')));
}
$(".btnExport").click(function(event) {
 convert_excel('xlsx');
});
</script>

<script src="<?php echo $theme_link; ?>js/report-sales-item.js"></script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
