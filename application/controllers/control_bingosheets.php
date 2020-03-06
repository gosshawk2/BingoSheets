<?php
/**
 * CLASS: createbingosheets extends CI_Controller.
 * 
 * @author Daniel Goss copyright DECEMBER 2016
 * 
 * Create and manage PDF files produced.
 */

class control_bingosheets extends CI_Controller
{   
     /**
     * Constructor of bingo sheets model.
     * 
     * Loads bingosheets_model, 
	*Loads bingosheets language package.
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('bingodata_model');
        $this->load->model('Progress_model');
	$this->load->model(array('CI_auth', 'CI_menu'));
        $this->load->library(array('session'));
        $this->load->library('Pdf');
        $this->load->helper('url');
        //$this->lang->load('bingosheets_en'); // language file
    }

    public function show_datarows($startrow,$endrow)
    {
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['rows']=$this->bingodata_model->read_rowdata();
        
        $data['control']= 'Show_rows:'.$startrow.';'.$endrow;
        $data['header'] = 'bingosheets_views/bingo_header_view';
        $data['footer'] = 'bingosheets_views/bingo_footer_view';
        $data['pagetitle'] = $this->lang->line('sheet_title1');
        $this->load->view('bingosheet_control_view',$data);
    }
    
    /**
     * Listing of all progress - no. of pdf pages produced and
     * by who and when.

     * Reads all entries from the progress table. 
     * 
     */
    
    public function index()
    {
        $criteria = array();
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['rows'] = $this->Progress_model->read_all_progress();
	   $data['control'] = 'Show_ALL_Progress';
	   $data['header'] = 'bingosheets_views/bingo_header_view';
        $data['footer'] = 'bingosheets_views/bingo_footer_view';
        $data['pagetitle'] = $this->lang->line('sheet_title1');
        $this->load->view('bingosheet_control_view',$data);

    }

    public function add_PDF_page($filename,$pages)
    {
        //Create PDF Page - store in a separate folder called PDFs.
	  	//Get details first from my_bingodata table
        $content =array(
        	'<html><body>Document 1</body></html>',
        	'<html><body>Document 2</body></html>',
        	'<html><body>Document 3</body></html>'
        	);
        	
	  	foreach($content as $i=>$html)
	  	{
	  	
			$pdf = new TCPDF('P', 'pt', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('Pdf Example').$i;
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetHeaderMargin(10);
			$pdf->SetTopMargin(10);
			$pdf->setFooterMargin(20);
			$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('DanGoss');
			$pdf->AddPage();
			//$pdf->SetDisplayMode('real', 'default');
			$pdf->WriteHTML($html,true,FALSE,TRUE,FALSE,'');
			$pdf->lastPage();
			$pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/' .$filename . $i . '.pdf', 'F');
		}
    }
	
	public function create_pdf($filename,$pages) {
    //============================================================+
    // File name   : example_001.php
    //
    // Description : Example 001 for TCPDF class
    //               Default Header and Footer
    //
    // Author: Muhammad Saqlain Arif
    //
    // (c) Copyright:
    //               Muhammad Saqlain Arif
    //               PHP Latest Tutorials
    //               http://www.phplatesttutorials.com/
    //               saqlain.sial@gmail.com
   //		Modified by: Daniel Goss on 08-DEC-2016
    //============================================================+
 
   
  
    // create new PDF document
    $PDF_HEADER_TITLE = 'BINGO SHEETS';
    
    for ($ii=0; $ii < $pages; $ii++):
    	$title = 'Test Tote / Pallet Sheet'.$ii;
    	$storage = "Tote";
    	$SKU = '123456789';
    	$description = 'BOSCH SUPER PLUS FR7DCX+';
    	$barcodenumber = '123456789';
    	$toteQty = '550';
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);    
  
    // set document information
    $pdf->SetCreator('Daniel Goss - 13-12-2016');
    $pdf->SetAuthor('Daniel Goss - 08/12/2016');
    $pdf->SetTitle('Bingo Sheets');
    $pdf->SetSubject('Create Bingo Sheets');
    $pdf->SetKeywords('TCPDF, PDF, Bingo Sheets, guide');   
  
    // set default header data
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
  
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
  
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
  
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
  
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
  
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
  
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }   
  
    // ---------------------------------------------------------    
  
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);   
  
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);   
  
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage(); 
  
    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
  
    // Set some content to print
    $html = <<<EOD
    <table style="text-align: left; width: 594px;" border="1" cellpadding="2" cellspacing="2">

  <tbody>
    <tr>
      <td class=\"noborders\" colspan="16" style="vertical-align: top; text-align: center;"><big><big>$title</big></big>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
     <tr>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td rowspan="2" colspan="9" style="vertical-align: top; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" style="vertical-align: top; width: 35px;">$storage
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
       <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" style="vertical-align: top; border:none;">Pick Tower
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" style="vertical-align: top;">SKU Number:<br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td colspan="9" style="vertical-align: top; text-align: center; border:none;">$SKU
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" style="vertical-align: top; width: 35px;">Description:
      </td>
      <td colspan="11" style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
      <td style="vertical-align: top; width: 35px; border:none;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 35px;">Barcode Number:<br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td colspan="9" rowspan="1" style="vertical-align: top; width: 35px; text-align: center;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
    </tr>
    <tr>
      <td colspan="4" rowspan="1" style="vertical-align: top; width: 31px;">Pallet Quantity:<br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td colspan="2" rowspan="1" style="vertical-align: top; width: 34px; text-align: center;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 40px;"><br>
      </td>
      <td style="vertical-align: top; width: 32px;"><br>
      </td>
      <td style="vertical-align: top; width: 31px;"><br>
      </td>
      <td style="vertical-align: top; width: 36px;"><br>
      </td>
      <td style="vertical-align: top; width: 34px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 46px;"><br>
      </td>
      <td style="vertical-align: top; width: 26px;"><br>
      </td>
      <td style="vertical-align: top; width: 15px;"><br>
      </td>
      <td style="vertical-align: top; width: 26px;"><br>
      </td>
      <td style="vertical-align: top; width: 20px;"><br>
      </td>
      <td style="vertical-align: top; width: 35px;"><br>
      </td>
      <td style="vertical-align: top; width: 42px;"><br>
      </td>
      <td style="vertical-align: top; width: 46px;"><br>
      </td>
      <td style="vertical-align: top; width: 27px;"><br>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; width: 35px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 40px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 32px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 31px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 36px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 34px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 35px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 46px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 26px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 15px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 26px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 20px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 35px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 42px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 46px;">9999<br>
      </td>
      <td style="vertical-align: top; width: 27px;">9999<br>
      </td>
    </tr>
    </tbody>
    </table>
     
EOD;
  
    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    endfor;
  
    // ---------------------------------------------------------    
  
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
  	//$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/'.'PDFtesting.pdf', 'F');
  	$pdf->Output($filename.'.pdf', 'I');
  	print('FINISHEd');
    //============================================================+
    // END OF FILE
    //============================================================+
    }

	
    public function readxml()
    {
        $data['menu_top'] = $this->CI_menu->menu_top();
        //$data['diaries']=$this->mydiary_model->read_diary_with_users();

        $data['control']= 'readxml';
        $data['header'] = 'bingosheets_views/bingo_header_view';
        $data['footer'] = 'bingosheets_views/bingo_footer_view';
        $data['pagetitle'] = $this->lang->line('sheet_title');
        $this->load->view('bingosheet_control_view',$data);


    }

    public function view_pdf()
    {
        $data['menu_top'] = $this->CI_menu->menu_top();
                
        $data['control']= 'pdf_view';
        $data['header'] = 'bingosheets_views/bingo_header_view';
        $data['footer'] = 'bingosheets_views/bingo_footer_view';
        $data['pagetitle'] = $this->lang->line('sheet_title');
        $this->load->view('bingosheet_control_view',$data);

    }
    
    
    
    public function LoadASNtoDropdown()
    {  
        // Load ASN entries to dropdown into long format using 	  //	custom helper function.
        // See helpers folder.
        
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['control']= 'Get_ASN_into_dropdown';
        $data['header'] = 'bingosheets_views/bingo_header_view';
        $data['footer'] = 'bingosheets_views/bingo_footer_view';
        $data['pagetitle'] = $this->lang->line('sheet_title');
        $this->load->view('bingosheet_control_view',$data);

    }
        
    
    public function delete_progress()
    {
        $id = $this->input->post('txt_id');
        $this->progress_model->delete(intval($id));
        redirect('control_bingosheets');
    }
    
    public function searchProgressByDate()
    {
        $criteria=trim($this->input->post('txt_search'));
        if ($criteria != '')
        {
            $data['rows']=$this->progress_model->find(
                    'progress.created',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'progressview';
		 	$data['header'] = 'bingosheets_views/bingo_header_view';
        	$data['footer'] = 'bingosheets_views/bingo_footer_view';
        	$data['pagetitle'] = $this->lang->line('sheet_title');
        	$this->load->view('bingosheet_control_view',$data);
        }
        else
        {
            // clicked search with no search data
            redirect('control_bingosheets');
        }
    }
    
    public function searchData($field)
    {
    		//$field = $this->uri->segment(3);
            $data['rows'] = $this->bingodata_model->find(
                    'my_bingodata.PNO',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'enter_search_'.$field;
		 	$data['header'] = 'bingosheets_views/bingo_header_view';
        	$data['footer'] = 'bingosheets_views/bingo_footer_view';
        	$data['pagetitle'] = $this->lang->line('sheet_title3');
        	$this->load->view('bingosheet_control_view',$data);
    }
    
    public function searchDataByPNO()
    {
        $criteria=trim($this->input->post('txt_PNO'));
        echo "SEARCH DATA BY PNO<br><br>";
        if ($criteria != '')
        {
            echo "PNO = ".$criteria;
            echo "<br><br><br>";
            $data['rows'] = $this->bingodata_model->find(
                    'my_bingodata.PNO',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'View_search_PNO';
		 	$data['header'] = 'bingosheets_views/bingo_header_view';
        	$data['footer'] = 'bingosheets_views/bingo_footer_view';
        	$data['pagetitle'] = $this->lang->line('sheet_title3');
        	$this->load->view('bingosheet_control_view',$data);
        }
        else
        {
            // clicked search with no search data
            redirect('control_bingosheets');
        }
    }
    
    public function searchDataByASN()
    {
        $criteria=trim($this->input->post('txt_ASN'));
        echo "SEARCH DATA BY ASN<br><br>";
        if ($criteria != '')
        {
        	echo "ASN = ".$criteria;
            echo "<br><br><br>";
            $data['rows']=$this->bingodata_model->find(
                    'my_bingodata.ASN',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'View_search_ASN';
		 	$data['header'] = 'bingosheets_views/bingo_header_view';
        	$data['footer'] = 'bingosheets_views/bingo_footer_view';
        	$data['pagetitle'] = $this->lang->line('sheet_title3');
        	$this->load->view('bingosheet_control_view',$data);
        }
        else
        {
            // clicked search with no search data
            redirect('control_bingosheets');
        }
    }
    
    public function searchDataByDAY()
    {
        $criteria=trim($this->input->post('txt_DAY'));
        echo "SEARCH DATA BY DAY<br><br>";
        if ($criteria != '')
        {
            echo "DAY = ".$criteria;
            echo "<br><br><br>";
            $data['rows']=$this->bingodata_model->find(
                    'my_bingodata.ASNDAY',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'View_search_DAY';
		 	$data['header'] = 'bingosheets_views/bingo_header_view';
        	$data['footer'] = 'bingosheets_views/bingo_footer_view';
        	$data['pagetitle'] = $this->lang->line('sheet_title3');
        	$this->load->view('bingosheet_control_view',$data);
        }
        else
        {
            // clicked search with no search data
            redirect('control_bingosheets');
        }
    }
    
    public function credits()
    {
      echo "CREDITS:";
      echo "<br /><br />";
      $data['menu_top'] = $this->CI_menu->menu_top();
      $data['control'] = 'credits';
      $data['header'] = 'bingosheets_views/bingo_header_view';
      $data['footer'] = 'bingosheets_views/bingo_footer_view';
      $data['pagetitle'] = $this->lang->line('sheet_title1');
      $this->load->view('bingosheet_control_view',$data);

    }
    
    public function register()
    {
      echo "THIS is the REGISTER function in main controller";
    }
}
?>