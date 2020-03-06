<script type="text/javascript">
    function deleteconfirm(dailydate)
    {
        var answer = confirm("Are you sure you want to remove " +
            dailydate + "?");
        if (answer)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
</script>

<h3><?php echo $this->lang->line('mydiary_title1'); ?></h3>
<?php
//echo "<br /><br />".anchor('mydiary/add', $this->lang->line('add'))." ";
echo form_open('mydiary/searchByDate', 'name="form_search"');
echo form_label($this->lang->line('search_text'), 'txt_search');
if (!isset($currentDate))
{
    $currentDate = 'Enter a date';
}
$data = array(
    'name' => 'txt_search',
    'id' => 'txt_search',
    'maxlength' => '50',
    'value' => $currentDate,
    'size' => '30'
);
echo form_input($data);
echo form_submit('btn_search', $this->lang->line('btnsearch'));
echo form_close();
?>
<table border='1'>
    <thead>
        <tr>
            <th><?php echo $this->lang->line('date'); ?></th>
            <th><?php echo $this->lang->line('brief'); ?></th>
            <th><?php echo $this->lang->line('entry'); ?></th>
            <th><?php echo $this->lang->line('private'); ?></th>
            <th><?php echo $this->lang->line('edit'); ?></th>
            <th><?php echo $this->lang->line('delete'); ?></th>
        </tr>
    </thead>
<tbody>
    <?php
    if (isset($diaries)):
        foreach ($diaries as $entry):
            echo '<tr>';
            echo '<td>' . $entry->date . '</td>';
            echo '<td><textarea rows="5" cols="40">' . $entry->brief . '</textarea></td>';
            echo '<td><textarea rows="5" cols="40">' . $entry->entry . '</textarea></td>';
            echo '<td><textarea rows="5" cols="40">' . $entry->privateentry . '</textarea></td>';
            echo '<td>' . anchor('mydiary/edit/' . $entry->id, $this->lang->line('edit')) . '</td>';
            echo '<td>';
              echo form_open ('mydiary/delete', 'name="form_delete"');
              echo form_hidden('txt_id', set_value('id', $entry->id));
              echo '<input type="submit" value="X" ' . 
                           'onclick="return deleteconfirm(\'' .  
                            $entry->date . '\');" />';
              echo form_close();
            echo '</td>'; 
           echo '</tr>';
        endforeach;
    endif;
    
    ?>
</tbody>
</table>
<?php echo "<br /><br />End of Diary Entries"; ?>

