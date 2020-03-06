<TABLE>
 <TR style=" background="raindrop.jpg";color:white;">
    <?php
    foreach($menu as $link_text=>$link_url):?>
      <TD>
        <li><a href="<?php echo $link_url; ?>">
        <?php echo $link_text; ?>
        </a></li>
        <?php echo $separator; ?>
      </TD>
    <?php endforeach; ?>
 </TR>
</TABLE>
