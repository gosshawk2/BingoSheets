<h3><?php echo $this->lang->line('mydiary_title2'); ?></h3>
<?php
echo form_open('mydiary/save', 'name="form_entry"');
//$data = array('name' => 'txt_action','id' => 'txt_action','value' => 'add');
//echo form_hidden('txt_id', set_value('id', $id));
$subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
$Curtime = date("Y-m-d H:i:s",$subhour);
echo form_label($this->lang->line('Enterdate'), 'txt_date'); //convert to datetime
$data = array('name' => 'txt_date','id' => 'txt_date','value' => $Curtime,'maxlength' => '50','size' => '30');
echo br(1);
echo form_input($data);
echo br(2);
echo form_label($this->lang->line('Enterbrief'), 'txt_brief');
$data = array('name' => 'txt_brief','id' => 'txt_brief','cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($data);
echo br(2);
echo form_label($this->lang->line('Enterdetail'), 'txt_detail');
$data = array('name' => 'txt_detail','id' => 'txt_detail','cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($data);
echo br(2);
echo form_label($this->lang->line('Enterprivatedetail'), 'txt_privateentry');
$data = array('name' => 'txt_privateentry','id' => 'txt_detail','cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($data);
echo br(2);
echo form_submit('btn_save', $this->lang->line('btnsave')); //replace with orangebutton class like register form
$js = 'onClick="history.go(-1)"';
echo form_button('btn_cancel', $this->lang->line('cancel'), $js);
echo form_close();
?>


