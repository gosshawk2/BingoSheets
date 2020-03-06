<?php
	$this->load->helper('form');
	echo form_open('control_bingosheets/searchDataByPNO', 'name="form_PNO_entry"');
	//$data = array('name' => 'txt_action','id' => 'txt_action','value' => 'add');
	//echo form_hidden('txt_id', set_value('id', $id));
	//LOAD THE FORM HELPER !!!
	$subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
	$Curtime = date("Y-m-d H:i:s",$subhour);
	$attributes = 'CLASS = /"fontsize25/"';
	echo "<br><br><br>";
	echo "<table><tr><td>";
	echo form_label($this->lang->line('search_PNO'), 'txt_PNO', $attributes); //convert to datetime
	$data = array('name' => 'txt_PNO','id' => 'txt_PNO','value' => '','maxlength' => '9','size' => '7');
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
