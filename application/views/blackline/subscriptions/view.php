
<div id="main">
<div id="options">
			<a href="<?=base_url()?>subscriptions/update/<?=$subscription->id;?>/view" class="btn" data-toggle="modal"><i class="icon-edit"></i> <?=$this->lang->line('application_edit_subscription');?></a>
			<a href="<?=base_url()?>subscriptions/item/<?=$subscription->id;?>" class="btn" data-toggle="modal"><i class="icon-plus-sign"></i> <?=$this->lang->line('application_add_item');?></a>
			<div class="visible-phone"><br/></div>
			<?php  if($subscription->end_date > $subscription->next_payment && date("Y-m-d") >= date('Y-m-d', strtotime('-3 day', strtotime ($subscription->next_payment)))){ ?>
			<a href="<?=base_url()?>subscriptions/create_invoice/<?=$subscription->id;?>" class="btn"><i class="icon-plus-sign"></i> <?=$this->lang->line('application_create_invoice');?></a>
			<?php } ?>
			<?php if($subscription->status != "Paid" && isset($subscription->company->name)){ ?><a href="<?=base_url()?>subscriptions/sendsubscription/<?=$subscription->id;?>" class="btn"><i class="icon-envelope"></i> <?=$this->lang->line('application_send_subscription_to_client');?></a><?php } ?>

		</div>
		<hr>
		<div class="row">
		<div class="span12 marginbottom20">
		<div class="table_head"><h6><?=$this->lang->line('application_subscription_details');?></h6></div>
		<div class="subcont">
		<ul class="details span6">
			<li><span><?=$this->lang->line('application_subscription_id');?>:</span> <?=$subscription->reference;?></li>
			<li class="<?=$subscription->status;?>"><span><?=$this->lang->line('application_status');?>:</span>
			<a class="label <?php if($subscription->status == 'Active'){ echo 'label-success';}else{echo 'label-important'; } ?>"><?php if($subscription->end_date <= date('Y-m-d') && $subscription->status != "Inactive"){ echo $this->lang->line('application_ended'); }else{ echo $this->lang->line('application_'.$subscription->status);}?></a>
			<?php if($subscription->subscribed != "0"){ ?>  <a class="label label-success margin-left-5 tt" title="<?php $unix = human_to_unix($subscription->subscribed.' 00:00'); echo date($core_settings->date_format, $unix);?>" ><?=$this->lang->line('application_subscribed_via_paypal');?></a> <?php } ?>
			</li>
			<li><span><?=$this->lang->line('application_issue_date');?>:</span> <?php $unix = human_to_unix($subscription->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<li><span><?=$this->lang->line('application_end_date');?>:</span> <a class="label <?php if($subscription->end_date <= date('Y-m-d') && $subscription->status != "Inactive"){ echo 'label-success tt" title="'.$this->lang->line('application_subscription_has_ended'); } ?>"><?php $unix = human_to_unix($subscription->end_date.' 00:00'); echo date($core_settings->date_format, $unix);?></a></li>
			<li><span><?=$this->lang->line('application_frequency');?>:</span> 
				
					<?php $freq = array('+7 day'  => $this->lang->line('application_weekly'),
                  '+14 day' => $this->lang->line('application_every_other_week'),
                  '+1 month' => $this->lang->line('application_monthly'),
                  '+3 month' => $this->lang->line('application_quarterly'),
                  '+6 month' => $this->lang->line('application_semi_annually'),
                  '+1 year' => $this->lang->line('application_annually')); 
					echo $freq[$subscription->frequency];
                  ?>
				</li>
			<li><span><?=$this->lang->line('application_next_payment');?>:</span> <a class="label <?php 
			if($subscription->status == "Active" && $subscription->next_payment > date('Y-m-d')){
				echo 'label-success ';} 
			if($subscription->next_payment <= date('Y-m-d') && $subscription->end_date > $subscription->next_payment && $subscription->status != "Inactive"){ 
				echo 'label-important tt" title="'.$this->lang->line('application_new_invoice_needed'); 
			} ?>"><?php $unix = human_to_unix($subscription->next_payment.' 00:00'); 
			if($subscription->end_date >= $subscription->next_payment){ 
				echo date($core_settings->date_format, $unix); 
			}else{ echo "-";} ?>
		</a></li>
		<span class="visible-phone"></span>
		
		</ul>
		<ul class="details span6">
			<?php if(isset($subscription->company->name)){ ?>
			<li><span><?=$this->lang->line('application_company');?>:</span> <a href="<?=base_url()?>clients/view/<?=$subscription->company->id;?>" class="label label-info"><?=$subscription->company->name;?></a></li>
			<li><span><?=$this->lang->line('application_contact');?>:</span> <?php if(isset($subscription->company->client->firstname)){ ?> <?=$subscription->company->client->firstname;?> <?=$subscription->company->client->lastname;?> <?php }else{echo "-";} ?></li>
			<li><span><?=$this->lang->line('application_street');?>:</span> <?=$subscription->company->address;?></li>
			<li><span><?=$this->lang->line('application_city');?>:</span> <?=$subscription->company->zipcode;?> <?=$subscription->company->city;?></li>
			<li><span><?=$this->lang->line('application_website');?>:</span> <?=$subscription->company->website;?></li>

			<?php }else{ ?>
				<li><?=$this->lang->line('application_no_client_assigned');?></li>
			<?php } ?>
		</ul>
		<br clear="all">
		</div>
		</div>
		</div>

		<div class="row">
		<div class="table_head"><h6><i class="icon-list-alt"></i><?=$this->lang->line('application_subscription_items');?></h6><a href="<?=base_url()?>subscriptions/item/<?=$subscription->id;?>" class="btn btn-mini pull-right" data-toggle="modal"><i class="icon-plus-sign"></i> <?=$this->lang->line('application_add_item');?></a></div>
		<table id="items" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
		<th width="4%"><?=$this->lang->line('application_action');?></th>
			<th><?=$this->lang->line('application_name');?></th>
			<th class="hidden-phone"><?=$this->lang->line('application_description');?></th>
			<th width="8%"><?=$this->lang->line('application_hrs_qty');?></th>
			<th width="12%"><?=$this->lang->line('application_unit_price');?></th>
			<th width="12%"><?=$this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php foreach ($items as $value):?>
		<tr id="<?=$value->id;?>" >
			<td class="option btn-group">
				<a href="<?=base_url()?>subscriptions/item_update/<?=$subscription->subscription_has_items[$i]->id;?>" class="btn btn-mini tt" title="<?=$this->lang->line('application_edit');?>" data-toggle="modal"><i class="icon-edit"></i></a>
				<a href="<?=base_url()?>subscriptions/item_delete/<?=$subscription->subscription_has_items[$i]->id;?>/<?=$subscription->id;?>" class="btn btn-mini tt" title="<?=$this->lang->line('application_delete');?>"><i class="icon-trash"></i>
			</td>
			<td class="hidden-phone"><?php echo $subscription->subscription_has_items[$i]->name;?></td>
			<td><?=$subscription->subscription_has_items[$i]->description;?></td>
			<td align="center"><?=$subscription->subscription_has_items[$i]->amount;?></td>
			<td><? echo sprintf("%01.2f",$subscription->subscription_has_items[$i]->value);?></td>
			<td><? echo sprintf("%01.2f",$subscription->subscription_has_items[$i]->amount*$subscription->subscription_has_items[$i]->value);?></td>

		</tr>
		
		<?php $sum = $sum+$subscription->subscription_has_items[$i]->amount*$subscription->subscription_has_items[$i]->value; $i++;?>
		
		<?php endforeach;
		if($items == NULL){ echo "<tr><td colspan='6'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
		if(substr($subscription->discount, -1) == "%"){ $discount = sprintf("%01.2f", round(($sum/100)*substr($subscription->discount, 0, -1), 2)); }
	    else{$discount = $subscription->discount;}
	    $sum = $sum-$discount;
		$tax = sprintf("%01.2f", round(($sum/100)*$core_settings->tax, 2));
		$sum = sprintf("%01.2f", round($sum+$tax, 2));
		?>
		<?php if ($subscription->discount != 0): ?>
		<tr>
			<td colspan="5" align="right"><?=$this->lang->line('application_discount');?></td>
			<td>- <?=$subscription->discount;?></td>
		</tr>	
		<?php endif ?>
		
		<?php if ($core_settings->tax != "0"){ ?>
		<tr>
			<td colspan="5" align="right"><?=$this->lang->line('application_tax');?> (<?= $core_settings->tax?>%)</td>
			<td><?=$tax?></td>
		</tr>
		<?php } ?>
		<tr class="active">
			<td colspan="5" align="right"><?=$this->lang->line('application_total');?></td>
			<td> <?=$subscription->currency?> <?=$sum;?></td>
		</tr>
		</table>
		

		</div>
	 	<?php if($core_settings->paypal == "1" && $sum != "0.00" && $subscription->subscribed == "0"){ ?><br/>	
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			  <input type="hidden" name="cmd" value="_xclick-subscriptions">
			  <input type="hidden" name="business" value="<?=$core_settings->paypal_account;?>">
			  <input type="hidden" name="item_name" value="<?=$this->lang->line('application_subscription');?> #<?=$subscription->reference;?>">
			  <input type="hidden" name="item_number" value="<?=$subscription->reference;?>">
			  <input type="hidden" name="image_url" value="<?=base_url()?><?=$core_settings->invoice_logo;?>">
			  <input type="hidden" name="no_shipping" value="1">
			  <input type="hidden" name="return" value="<?=base_url()?>csubscriptions/view/<?=$subscription->id;?>">
			  <input type="hidden" name="cancel_return" value="<?=base_url()?>csubscriptions/view/<?=$subscription->id;?>"> 
			  <input type="hidden" name="currency_code" value="<?= $core_settings->paypal_currency;?>">
			  <input type="hidden" name="rm" value="2">
			  <input type="hidden" name="a3" value="<?=$sum;?>">
			  <input type="hidden" name="p3" value="<?=$p3;?>">
			  <input type="hidden" name="t3" value="<?=$t3;?>">
			  <input type="hidden" name="src" value="1">
			  <input type="hidden" name="sra" value="1">
			  <input type="hidden" name="srt" value="<?=$run_time;?>">
			  <input type="hidden" name="no_note" value="1">
			  <input type="hidden" name="invoice" value="<?=$subscription->reference;?>">
			  <input type="hidden" name="usr_manage" value="1">
			  <input type="hidden" name="notify_url" value="<?=base_url()?>paypalipn" /> 
			  <input type="hidden" name="custom" value="subscription-<?=$sum;?>">
			  <input class="btn btn-primary pull-right" type="submit" value="<?=$this->lang->line('application_subscribe_via_paypal');?>" border="0" name="submit" >
		</form>
			<br clear="all">
		 <?php } ?>	


		 

	</div>
	<br clear="all">
	<div class="row">
		<div class="table_head"><h6><i class="icon-list-alt"></i><?=$this->lang->line('application_subscription');?> <?=$this->lang->line('application_invoices');?></h6></div>
		<table class="data" id="invoices" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="hidden-phone" width="70px"><?=$this->lang->line('application_invoice_id');?></th>
			<th class="hidden-phone"><?=$this->lang->line('application_client');?></th>
			<th><?=$this->lang->line('application_issue_date');?></th>
			<th><?=$this->lang->line('application_due_date');?></th>
			<th><?=$this->lang->line('application_status');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($subscription->invoices as $value):?>

		<tr id="<?=$value->id;?>" >
			<td class="hidden-phone"><?=$value->reference;?></td>
			<td class="hidden-phone"><span class="label label-info"><?php if(!isset($value->company->name)){echo $this->lang->line('application_no_client_assigned'); }else{ echo $value->company->name; }?></span></td>
			<td><span><?php $unix = human_to_unix($value->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></span></td>
			<td><span class="label <?php if($value->status == "Paid"){echo 'label-success';} if($value->due_date <= date('Y-m-d') && $value->status != "Paid"){ echo 'label-important tt" title="'.$this->lang->line('application_overdue'); } ?>"><?php $unix = human_to_unix($value->due_date.' 00:00'); echo date($core_settings->date_format, $unix);?></span></td>
			<td><span class="label <?php $unix = human_to_unix($value->sent_date.' 00:00'); if($value->status == "Paid"){echo 'label-success';}elseif($value->status == "Sent"){ echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);} ?>"><?=$this->lang->line('application_'.$value->status);?></span></td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>invoices/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?=base_url()?>invoices/update/<?=$value->id;?>" class="btn btn-mini" data-toggle="modal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	<br clear="all">
	</div>