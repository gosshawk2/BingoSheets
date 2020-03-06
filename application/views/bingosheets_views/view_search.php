<?php
	$this->load->helper('form');
	$this->load->helper('url');
	$subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
	$Curtime = date("Y-m-d H:i:s",$subhour);
	$attributes = 'CLASS = /"fontsize25/"';
	$field = $this->uri->segment(3);
	echo "<br><br><br>";
	echo "<table><tr><td>";
	echo "
<table border='1'>
    <thead>
    	<tr>
    		<td>Searched:'$field'</td>
    	</tr>
        <tr>
            <th>ASN</th>
            <th>DAY</th>
            <th>PNO</th>
            <th>QTY</th>
            <th>PSR</th>
            <th>Home Slot</th>
            <th>Storage</th>
            <th>Unit Per Storage</th>
            <th>PAGES</th>
            <th>Check</th>
            <th>Description</th>
            <th>Full Tote</th>
            <th>Qty Per Full Tote</th>
            <th>Half Tote</th>
            <th>Qty Per Half Tote</th>
            <th>Total Qty greater than 300</th>
            <th>MAX Qty greater than 300</th>
            <th>MAX Per Sheet</th>
            <th>id</th>
            <th>SELECTED</th>
        </tr>
    </thead>";
    echo "<tbody>";
    if (isset($rows)):
    	$entries = 1;
        foreach ($rows as $entry): 
          echo "<tr>";
            echo "<td>" . $entry->ASNNO . "</td>";
            echo "<td>" . $entry->ASNDAY . "</td>";
            echo "<td>" . $entry->PNO . "</td>";
            echo "<td>" . $entry->SUMOFORDQTY . "</td>";
            echo "<td>";
            echo '<input type=/"checkbox/" name=/"chkbox[]/" value=/"'.$entry->id.'/"/>';
            	
            
              //echo form_open ('mydiary/delete', 'name="form_delete"');
              //echo form_hidden('txt_id', set_value('id', $entry->id));
              
              //echo form_close();
            echo '</td>'; 
          echo '</tr>';
          $entries++;
        endforeach;
        echo "</tbody></table>";
        echo "<br><br>--- Total Number of $control Entries: $entries";
        echo '<br><input type="submit" value="CreatePDF"/>';
		if(isset($_POST['CreatePDF']))
		{
 			$cnt=array();
 			$cnt=count($_POST['chkbox']);
 			for($i=0;$i<$cnt;$i++)
  			{
     			$selected_id=$_POST['chkbox'][$i];
     			echo "<br>Selected record IDs: $selected_id";
  			}
		}
		//now we have a whole bunch of IDs hmmmm what we need is a RANGE.
		//we need to know the start row and end rows which would be easy here - if we do not 
		//allow the user to SELECT individual rows !
		//the idea was to read all of the data into a large array.
		//now we need to search the database - if it is available !
		//although we would have not go this far if there was a problem with the database !
		//other versions could read in from an xml file or comma delim file and insert into a 
		//large array.
		//SO from the id we search the database to return the whole row. This can then be passed        
    endif;
    
?>
