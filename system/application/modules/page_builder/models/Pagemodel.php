<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagemodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('ion_auth');
        
    }
    
    
    /*
    
    	get page meta data for an entire site
    
    */
    
    public function getPageData($siteID) {
    
    	$query = $this->db->from('pages')->where('sites_id', $siteID)->get();
    	    	
    	if( $query->num_rows() > 0 ) {
    	
    		$res = $query->result();
    		
    		$return = array();
    		
    		foreach( $res as $page ) {
    		
    			$return[$page->pages_name] = $page;
    		
    		}
    		    		
    		return $return;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    
    /*
    
    	retrieves meta data for single page, using the siteID and page name
    
    */
    
    public function getSinglePage($siteID, $pageName) {
    
    	$query = $this->db->from('pages')->where('sites_id', $siteID)->where('pages_name', $pageName)->get();
    
    	if( $query->num_rows() > 0 ) {
    	
    		$res = $query->result();
    	
    		return $res[0];
    	
    	} else {//no match found
    	
    		return false;
    	
    	}
    
    }
    
    
    
    
    /*
    
    	updates page meta data
    
    */
    
    public function updatePageData( $pageData ) {
    
    	//do we have a pageID?
    	
    	if( $pageData['pageID'] != '' ) {
    
    		$data = array(
				'pages_title' => $pageData['pageData_title'],
				'pages_meta_keywords' => $pageData['pageData_metaKeywords'],
				'pages_meta_description' => $pageData['pageData_metaDescription'],
				'pages_header_includes' => $pageData['pageData_headerIncludes'] 
   			);
    	
    		$this->db->where('pages_id', $pageData['pageID']);
    		$this->db->update('pages', $data);
    	
    	} else {
    	
    		//no pageID given, create a new page in the db
    		$data = array(
    		   'sites_id' => $pageData['siteID'],
    		   'pages_name' => $pageData['pageName'],
    		   'pages_timestamp' => time(),
    		   'pages_title' => $pageData['pageData_title'],
    		   'pages_meta_keywords' => $pageData['pageData_metaKeywords'],
    		   'pages_meta_description' => $pageData['pageData_metaDescription'],
    		   'pages_header_includes' => $pageData['pageData_headerIncludes'] 
    		);
    		
    		$this->db->insert('pages', $data); 
    	
    	}
    
    }
    
}