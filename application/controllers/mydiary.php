<?php
/**
 * Class definition for mydiary controller extends CI_Controller.
 *
 * Class definition for mydiary controller. Controller includes methods
 * to handle listing, inserting, editing and deleting mydiary entries.
 * Extends CI_Controller.
 * 
 * @author Daniel Goss copyright 2013
 */

class mydiary extends CI_Controller
{   
     /**
     * Constructor of a diary model.
     * 
     * Constructor of a mydiary model. Loads mydiary_model, language package.
     */    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('mydiary_model');
        $this->load->library(array('session'));
		$this->load->model(array('CI_auth', 'CI_menu'));
        $this->lang->load('mydiary'); // language file, strings in the page
    }

    public function show_diaries($control)
    {
        //$this->load->library('mydiary_menu_class');
        //$menu = new mydiary_menu_class;

        $data['menu_top'] = $this->CI_menu->menu_top();
        //$data['menu'] = $menu->show_menu();
        $data['diaries']=$this->mydiary_model->read_diary_with_users();
        
        $data['control']= $control;
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title');
        $this->load->view('mydiary_control_view',$data);
    }
    
    /**
     * Listing of all diaries for user logged in.
     * 
     * Reads all diary entries from the mydiary table. 
     * Uses the mydiary_views/diaries_view.
     * 
     */    
    public function index()
    {
        //$this->load->library('mydiary_menu_class');
        //$menu = new mydiary_menu_class;
        $criteria = array();
        $data['menu_top'] = $this->CI_menu->menu_top();
        //$data['menu'] = $menu->show_menu();

        $userId = $this->session->userdata('userId');
        if ($userId=0)
        {
            //$data['diaries'] = array();
        }
        $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
        $today = date("Y-m-d H:i:s",$subhour);
        $criteria = array('dailydiary.userid' => $userId,'dailydiary.dailydate' => $today);
        $data['userId'] = $userId;
        $data['diaries']=$this->mydiary_model->read_diary_with_users($criteria);
        $data['control']= 'diaryview';
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title');
        $this->load->view('mydiary_control_view',$data);
        
        /*$this->show_diaries('diaryview'); */
    }

    public function readxml()
    {
        $data['menu_top'] = $this->CI_menu->menu_top();
        //$data['diaries']=$this->mydiary_model->read_diary_with_users();

        $data['control']= 'readxml';
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title');
        $this->load->view('mydiary_control_view',$data);

    }

    public function news()
    {
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['diaries']=$this->mydiary_model->read_diary_with_users();
        
        $data['control']= 'news';
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title');
        $this->load->view('mydiary_control_view',$data);  
    }
    /**
     * Add a diary entry to the database.
     * 
     * Creates an empty diary entry and shows it.
     */    
    public function add()
    {
        //Load initial data to form.
        $data = array(
                'uniqueid'                     => '',
                'userid'                       => 1,
                'dailydate'                    => '',
                'dailybrief'                   => 'no entry',
                'dailyprivateentry'            => '',
                'dailyentry'                   => 'no entry',
            );
          
        // Load diary entries to dropdown into long format using custom helper function.
        // See helpers folder.
        
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['control']= 'entry';
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title2');
        $this->load->view('mydiary_control_view',$data);
    }

     /*
     * @param int $id Primary key of the student. 
     */    
    public function edit($id)
    {
       $entry=$this->mydiary_model->read_diary($id);

       //if diary entry is found from db, edit.
       if (isset($entry[0]))
       {
           $data = array(
                    'uniqueid'   => $entry[0]->UniqueID,
                    'userid'     => $entry[0]->userid,
                    'dailydate'  => $entry[0]->dailydate,
                    'dailybrief' => $entry[0]->dailybrief,
                    'dailyentry' => $entry[0]->dailyentry,
                    'dailyprivateentry' => $entry[0]->dailyprivateentry,
                    'private'    => $entry[0]->private
                );
           
        $data['menu_top'] = $this->CI_menu->menu_top();
        $data['control']= 'edit';
        $data['header'] = 'mydiary_views/mydiary_header_view';
        $data['footer'] = 'mydiary_views/mydiary_footer_view';
        $data['pagetitle'] = $this->lang->line('mydiary_title1');
        $this->load->view('mydiary_control_view',$data);
       }
       else 
       {
            redirect('mydiary');
       }
    }

     /**
     * Insert or update diary entry into the database.
     * 
     * Inserts or updates the diary entry into the student table. 
     * Validates the input data.
     */    
    public function save()
    {
        $update=FALSE;
        $private = 0;
        $privateDetail = $this->input->post('txt_privateentry');
        //Input values are read from post before validating
        //in case that form has to be repopulated due to invalid input.
        if (!empty($privateDetail))
        {
            $private = 1;
        }

        $data = array(
              'dailybrief'         => $this->input->post('txt_brief'),
              'dailydate'          => $this->input->post('txt_date'),
              'userid'             => $this->input->post('txt_userid'),
              'dailyprivateentry'  => $this->input->post('txt_privateentry'),
              'private'            => $private,
              'dailyentry'         => $this->input->post('txt_detail')
            );

        $this->load->library('form_validation');

         //Check if new record is created or updated.
        if (isset($_POST['txt_id']) AND (strlen($this->input->post("txt_id"))>0))
        {
            $update=TRUE;
            //echo "<p>FUCK YEA !</p>";
        }
        
        //Validate input.
        $this->form_validation->set_rules('txt_date', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //$data['diaries']= $this->mydiary__model->read_diary_with_users();
            $this->load->helper("form_input_helper");
            //$this->load->library('mydiary_menu_class');
            $data['menu_top'] = $this->CI_menu->menu_top();
        //$data['diaries']=$this->mydiary_model->read_diary_with_users();
            $data['control']= 'savefail';
            $data['header'] = 'mydiary_views/mydiary_header_view';
            $data['footer'] = 'mydiary_views/mydiary_footer_view';
            $data['pagetitle'] = $this->lang->line('mydiary_title1');
            $this->load->view('mydiary_control_view',$data);
        }
        else
        {
            //Insert or update
            if ($update==FALSE)
            {
                $this->mydiary_model->create($data);
                //add message to say created
            }
            else
            {
                
                $data['uniqueid']=intval($this->input->post('txt_id'));
                $this->mydiary_model->update($data);
                //add message to say updated ok
            }

            redirect('mydiary');
        }
    }
    
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $this->mydiary_model->delete(intval($id));
        redirect('mydiary');
    }
    
    /**
     * Search diary by the field name.
     */
    public function searchByDate($criteria)
    {
        $criteria=trim($this->input->post('txt_search'));
        if ($criteria != '')
        {
            $data['diaries']=$this->mydiary_model->find(
                    'dailydiary.dailydate',$criteria);
            $data['menu_top'] = $this->CI_menu->menu_top();
            $data['control'] = 'diaryview';
            $data['header'] = 'mydiary_views/mydiary_header_view';
            $data['footer'] = 'mydiary_views/mydiary_footer_view';
            $data['pagetitle'] = $this->lang->line('mydiary_title');
            $this->load->view('mydiary_control_view',$data);
            //$this->load->view('template',$data);
        }
        else
        {
            // clicked search with no search data
            redirect('mydiary');
        }
    }
    
    public function credits()
    {
      echo "CREDITS:";
      echo "<br /><br />";
      $data['menu_top'] = $this->CI_menu->menu_top();
      $data['control'] = 'credits';
      $data['header'] = 'mydiary_views/mydiary_header_view';
      $data['footer'] = 'mydiary_views/mydiary_footer_view';
      $data['pagetitle'] = $this->lang->line('mydiary_title');
      $this->load->view('mydiary_control_view',$data);
    }
    
    public function register()
    {
      echo "THIS is the REGISTER function in main controller";
    }
}
?>