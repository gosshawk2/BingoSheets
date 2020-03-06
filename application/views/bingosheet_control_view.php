<?php
  $this->lang->load('bingosheets_en');
  $title = $this->lang->line('sheet_title1');
  if(isset($debug) AND ($debug===TRUE))
  {
    if(isset($control))
    {
      echo "control=".$control."   ";
    }
    else
    {
      echo "control not set ";
    }
  }
?>
<html>
  <head>
  <title><?php echo $title ?></title>
  <meta name="author" content="Daniel Thomas Goss">
  <link href='<?php echo base_url(). "css/nav_slim2.css" ?>' rel="stylesheet" type="text/css" />
  </head>
  <body>
  <div id="header" align="center">
    <?php
      if(isset($header))
      { 
        $this->load->view('bingosheets_views/bingo_header_view');
      }
    ?>
  </div>
  <div id="nav_slim" align="left">
    <div id="nav_wrapper" align="left" >
    <?php 
      if (isset($menu_top))
      {
        $this->load->view('bingo_menu');
      }
       
    ?>
    </div>
  </div>
  <div id="maincontent" align="center">
    <?php
      if(isset($control) AND (strtoupper($control)=="BINGOVIEW"))
      {
       
      }
      elseif(isset($control) AND (strtoupper($control)=="ENTER_SEARCH_PNO"))
      {
        $this->load->view('bingosheets_views/enter_search_PNO');  
      }
      elseif(isset($control) AND (strtoupper($control)=="ENTER_SEARCH_ASN"))
      {
        $this->load->view('bingosheets_views/enter_search_ASN');  
      }
      elseif(isset($control) AND (strtoupper($control)=="ENTER_SEARCH_DAY"))
      {
        $this->load->view('bingosheets_views/enter_search_DAY');  
      }
      elseif(isset($control) AND (strtoupper($control)=="VIEW_SEARCH_DAY"))
      {
        $this->load->view('bingosheets_views/view_search/DAY');  
      }
      elseif(isset($control) AND (strtoupper($control)=="VIEW_SEARCH_ASN"))
      {
        $this->load->view('bingosheets_views/view_search/ASN');  
      }
     elseif(isset($control) AND (strtoupper($control)=="VIEW_SEARCH_PNO"))
      {
      	echo "<br><br>Execute View_Search";
        $this->load->view('bingosheets_views/view_search/PNO');  
      }
      elseif(isset($control) AND (strtoupper($control)=="EDIT"))
      {
        $this->load->view('bingosheets_views/bingo_edit');    
      }
      elseif(isset($control) AND (strtoupper($control)=="SAVEFAIL"))
      {
        echo "<p>SAVE FAILED</p>";
      }
      elseif(isset($control) AND (strtoupper($control)=="READXML"))
      {
          echo "<p>read xml</p>";

      }
      elseif(isset($control) AND (strtoupper($control)=="WRITEXML"))
      {
          echo "<p>write xml</p>";

      }
      elseif(isset($control) AND (strtoupper($control)=="NEWS"))
      {
        echo "<p>NEWS COMMING SOON...</P>";
      }
      elseif(isset($control) AND (strtoupper($control)=="CREDITS"))
      { 
        echo "<div id=\"credits\" align=\"center\">";
        echo "<p>";
            echo $this->lang->line('info')."<br /><br />";
            echo $this->lang->line('contact');
        echo "</p>";
        echo "</div>";
      }
      
      if (isset($body))
      {
        echo "<div class=\"wrapper\">";
        echo $body;
        echo "</div>";
      }
    ?>
  </div>
  <div id="footer" align="center">
    <?php
      if(isset($footer))
      { 
        //$this->load->view('bingosheets_views/bingo_footer_view');
      } 
    ?>
  </div>
  </body>
</html>

  
  