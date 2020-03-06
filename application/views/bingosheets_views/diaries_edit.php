<h3><?php echo $this->lang->line('mydiary_title3'); ?></h3>
<?php
echo form_open('mydiary/save', 'name="form_entry"');
//$data = array('name' => 'txt_action','id' => 'txt_action','value' => 'add');
//UPDATE `dailydiary` SET `dailybrief` = 'brief test', `dailydate` = '2013-11-24 19:36:00', `userid` = '1', `dailyentry` = 'detail tested again!', `id` = 5 WHERE `uniqueid` = 5
if (isset($userid))
{
  echo form_hidden('txt_userid', set_value('userid',$userid));
}
$subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
$Curtime = date("Y-m-d H:i:s",$subhour);
echo form_label($this->lang->line('id'),'txt_id');
$entry = array('name' => 'txt_id','id' => 'txt_id','value' => $uniqueid,'maxlength' => '10','size' => '5');
echo form_input($entry)." ";
echo form_label($this->lang->line('Enterdate'), 'txt_date'); //convert to datetime
$entry = array('name' => 'txt_date','id' => 'txt_date','value' => $dailydate,'maxlength' => '50','size' => '20');
//echo br(1);
echo form_input($entry);
echo br(2);
echo form_label($this->lang->line('Enterbrief'), 'txt_brief'); //convert to datetime
$entry = array('name' => 'txt_brief','id' => 'txt_brief','value' => $dailybrief,'cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($entry);
echo br(2);
echo form_label($this->lang->line('Enterdetail'), 'txt_detail'); //convert to datetime
$entry = array('name' => 'txt_detail','id' => 'txt_detail','value' => $dailyentry,'cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($entry);
echo br(2);
echo form_label($this->lang->line('Enterprivatedetail'), 'txt_privateentry');
$entry = array('name' => 'txt_privateentry','id' => 'txt_detail','cols' => '50','rows' => '3');
echo br(1);
echo form_textarea($entry);
echo br(2);
echo form_button('btn_save', $this->lang->line('btnsave'));
$js = 'onClick="history.go(-1)"';
echo form_button('btn_cancel', $this->lang->line('cancel'), $js);
echo form_close();
?>
