<TABLE cellspacing="0" cellpadding="0">
  <?php
    $this->load->helper('url');
    $backgroundPath = "index.php/images/sheep_webbanner.jpg";
    echo "<TR style=\"border-width: 5px; width: 100%; background-image: url($backgroundPath);\">";
   ?>
   <TD width="100px">
      &nbsp;
    </TD>
    <TD>
      <h3>
        <?php
            echo $this->lang->line('welcome');
   
        ?>
      </h3>
    </TD>
    <td>
    	<?php
    		echo "  ";
    	?>
    </td>
    <TD>
      <?php 
        echo anchor('control_bingosheets/login',$this->lang->line('login'));
        echo " / ";
        echo anchor('control_bingosheets/register',$this->lang->line('register'));
      ?>
    </TD>
  </TR>
</TABLE>

