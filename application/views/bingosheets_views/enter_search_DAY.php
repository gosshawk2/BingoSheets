<h3><?php echo $this->lang->line('mydiary_title2'); ?></h3>
<?php
	$this->load->helper('form');
	echo "<br><br><br>";
	echo form_open('control_bingosheets/searchDataByDAY', 'name="form_DAY_entry"');
	//$data = array('name' => 'txt_action','id' => 'txt_action','value' => 'add');
	//echo form_hidden('txt_id', set_value('id', $id));
	//LOAD THE FORM HELPER !!!
	$subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
	$Curtime = date("Y-m-d H:i:s",$subhour);
	echo "<table><tr><td>";
	echo form_label($this->lang->line('search_DAY'), 'txt_DAY'); //convert to datetime
	$data = array('name' => 'txt_DAY','id' => 'txt_DAY','value' => '','maxlength' => '8','size' => '7');
	echo "</td><td>";
	echo form_input($data);
	echo "</td><td>&nbsp;</td><td>";
	echo form_submit('btn_search', $this->lang->line('btnsearch')); //replace with orangebutton class like register form
	$js = 'onClick="history.go(-1)"';
	echo "</td><td>&nbsp;</td><td>";
	echo form_button('btn_cancel', $this->lang->line('cancel'), $js);
	echo form_close();
	echo "</td></tr></table>";
?>
