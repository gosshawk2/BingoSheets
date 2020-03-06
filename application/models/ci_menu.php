<?php
class CI_menu extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->database();
        $this->load->helper('url');
        $this->load->model(array('CI_auth'));
    }
    
    function create_menu($array_menu, $separator =' '){
        $data = array(
            'menu' => $array_menu,
            'separator' => $separator
        );
        return $this->load->view('_links2',$data, true);
    }
    
    function menu_top(){
        $filename = "test";
        $menu_common = array(
            'Home' => site_url().'/control_bingosheets',
            'View' => 
            	array(
            		'Search by PNO number' => site_url().'/control_bingosheets/searchData/PNO',
            		'Search by ASN number' => site_url().'/control_bingosheets/searchData/ASN',
            		'Search by DAY number' => site_url().'/control_bingosheets/searchData/DAY',
            	),
            'Actions' =>
                array(
                    'Add New BingoSheet' => site_url().'/control_BingoSheets/create_pdf/PDFtest/3',
                    'Import XML' => site_url().'/control_BingoSheets/readxml',
                    'Export XML' => site_url().'/control_BingoSheets/writexml'
                ),
            'Credits' => site_url().'/control_BingoSheets/credits'
        );
        
        $menu_unlogged = array(
            'Register' => site_url().'/control_bingosheets/register',
            'Login' => site_url().'/control_bingosheets/login'
        );
        
        $menu_logged = array(
            'My Account' =>
                array(
                    'Options' => site_url().'/control_bingosheets/options',
                    'Profile' => site_url().'/control_bingosheets/profile',
                    'User Management' => site_url().'/control_bingosheets/userManagement'
                ),
            'Logout' => site_url().'/control_bingosheets/login/logout'
        );
        
        $menu = array_merge($menu_common,($this->CI_auth->check_logged() == true)?$menu_logged:$menu_unlogged);
        return $this->create_menu($menu);
    }
    
}