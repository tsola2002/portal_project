<html>
<head>
<meta name="Author" content="<?= $core_settings->company?>"/>  
<meta http-equiv="Content-Type" content="charset=utf-8" />
<style type="text/css">

body {
  width:100%;
  font-family: "Helvetica", arial, sans-serif;
	font-size:12px;
}
.company_info {
  display: block;
  padding:15px 0;
  line-height: 12px;
  color:#444;
  font-size:10px;
}
.head_address {
  margin:10px 0;
	font-size: 11px;
  line-height:16px;
	color: #333;
	width: 300px;
  float:left;
}

.head_line_right {
	font-size: 11px;
	color: #333333;
	width: 300px;
  float:right;
}
table {
  width: 100%;
  margin: 0px auto;
  border-collapse: collapse;

 }
table.main tr.thead td {
  background:#f4f4f4;
  text-align:left;
  color:#444;
  font-weight:bold;
  font-size:11px;
  border-bottom:1px solid #CCC;
} 
table.main {
  clear:both;
  margin:40px 0px;
}
table.main td {
    padding: 5px !important;
}
td, tr {
  padding: 3px;
  background:;
  color:#666;
  font-size:12px;
}
.clear{
  clear:both;
}
.right{
  float:right;
}
.left{
  float:left;
}
.sum{
  border-top:1px solid #CCC;
 
}
.total{
  color:#111 !important;
}
</style>
</head>
<body>
<div class="clear">
<img src="<?php echo base_url(); ?><?=$core_settings->invoice_logo;?>">
<div>
<span class="company_info">
<?=$core_settings->company;?><br>
<?=$core_settings->invoice_contact;?><br>
<?=$core_settings->invoice_address;?><br>
<?=$core_settings->invoice_city;?><br>
<?=$core_settings->invoice_tel;?><br>
</span>
<div class="head_address">
<?=$invoice->company->name;?><br>
<?php if(isset($invoice->company->client->firstname)){ ?> <?=$invoice->company->client->firstname;?> <?=$invoice->company->client->lastname;?> <br><?php } ?>
<?=$invoice->company->address;?><br>
<?=$invoice->company->zipcode;?> <?=$invoice->company->city;?>
</div>

<div class="head_line_right clear">
 <table border="0">
      <tr>
        <td align="right"><?=$this->lang->line('application_invoice_date');?>:</td>
        <td><?php echo date($core_settings->date_format, human_to_unix($invoice->issue_date.' 00:00:00'));?></td>
      </tr>
      <tr>
        <td align="right"><?=$this->lang->line('application_client_reference');?>:</td>
        <td><?=$invoice->company->reference;?></td>
      </tr>
      <tr>
        <td align="right"><?=$this->lang->line('application_invoice_number');?>:</td>
        <td><?=$invoice->reference;?></td>
      </tr>
      <tr>
        <td align="right"><?=$this->lang->line('application_due_date');?>:</td>
        <td><strong><?php echo date($core_settings->date_format, human_to_unix($invoice->due_date.' 00:00:00'));?></strong></td>
      </tr>
    </table>
</div>
<br>
<table class="main">
  <tr class="thead">
    <td><?=$this->lang->line('application_item');?></td>
    <td><?=$this->lang->line('application_description');?></td>
    <td width="8%"><?=$this->lang->line('application_hrs_qty');?></td>
    <td width="12%"><?=$this->lang->line('application_unit_price');?></td>
    <td width="12%"><?=$this->lang->line('application_sub_total');?></td>
  </tr>
  
 <?php $i = 0; $sum = 0; $row=false; ?>
    <?php foreach ($items as $value):?>
    <tr <?php if($row){?>style="background:#F6F6F6"<?php } ?>>
      <td><?php if(!empty($value->name)){echo $value->name;}else{ echo $invoice->invoice_has_items[$i]->item->name; }?></td>
      <td><?=$invoice->invoice_has_items[$i]->description;?></td>
      <td align="center"><?=$invoice->invoice_has_items[$i]->amount;?></td>
      <td><? echo sprintf("%01.2f",$invoice->invoice_has_items[$i]->value);?></td>
      <td><? echo sprintf("%01.2f",$invoice->invoice_has_items[$i]->amount*$invoice->invoice_has_items[$i]->value);?></td>
    </tr>
    <?php $sum = $sum+$invoice->invoice_has_items[$i]->amount*$invoice->invoice_has_items[$i]->value; $i++; if($row){$row=false;}else{$row=true;}?>
    
    <?php endforeach;
    if(empty($items)){ echo "<tr><td colspan='5'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
    if(substr($invoice->discount, -1) == "%"){ $discount = sprintf("%01.2f", round(($sum/100)*substr($invoice->discount, 0, -1), 2)); }
    else{$discount = $invoice->discount;}
    $sum = $sum-$discount;
    $tax = sprintf("%01.2f", round(($sum/100)*$core_settings->tax, 2));
    $sum = sprintf("%01.2f", round($sum+$tax, 2));
    ?>
    <?php if ($invoice->discount != 0): ?>
    <tr>
      <td colspan="4" class="sum" align="right"><?=$this->lang->line('application_discount');?>:</td>
      <td class="sum">- <?=$invoice->discount;?></td>
    </tr> 
    <?php endif ?>
   <?php if($core_settings->tax != "0"){ ?>
    <tr>
      <td <?php if ($invoice->discount == 0){echo 'class="sum"';} ?> colspan="4" align="right"><?=$this->lang->line('application_tax');?> (<?= $core_settings->tax?>%):</td>
      <td <?php if ($invoice->discount == 0){echo 'class="sum"';} ?>><?=$tax?></td>
    </tr>
    <?php } ?>
    <tr class="total">
      <td colspan="4" align="right"><?=$this->lang->line('application_total');?>:</td>
      <td><?=$invoice->currency?> <?=$sum;?></td>
    </tr>
</table>
<br clear="both">
<p><?php echo $invoice->terms; ?></p>

</body>
</html>
