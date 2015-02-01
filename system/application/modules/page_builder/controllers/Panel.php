<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('sitemodel');
		$this->load->model('usermodel');
		$this->load->model('pagemodel');
		$this->load->config('builder/builder');

		$this->lang->load('builder/builderlite');

		$this->data['pageTitle'] = $this->lang->line('sites_page_title');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('panel/login');
		
		}

		$this->data['builder'] = true;
	}
	
	
	/*
	
		lists all sites
	
	*/

	public function index()
	{
		//grab us some sites
		$this->data['sites'] = $this->sitemodel->all();
		
		//get all users
		$this->data['users'] = $this->usermodel->getAll();
						
		$this->data['page'] = "sites";

		$this->template->view('sites', $this->data);
	}
	
	/*
	
		load page builder
	
	*/
	
	public function create() {
		
		//create a  new, empty site
		
		$newSiteID = $this->sitemodel->createNew();
		
		redirect('panel/builder/site/'.$newSiteID);
		
		//$this->data['builder'] = true;
		//$this->data['page'] = "newPage";
		//$this->load->view('sites/create', $this->data);
	
	}
	
	
	
	/*
	
		Used to create new sites AND save existing ones
	
	*/
	
	public function save( $forPublish = 0 ) {
	
		//do we have a site name?
		
		if( !isset($_POST['siteName']) || $_POST['siteName'] == '' ) {
					
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_save_error1_heading');
			$temp['content'] = $this->lang->line('sites_save_error1_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			die( json_encode($return) );
		
		}
		
		
		//do we have some frames to save?
		
		if( !isset($_POST['pageData']) || $_POST['pageData'] == '' ) {
			
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_save_error2_heading');
			$temp['content'] = $this->lang->line('sites_save_error2_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			die( json_encode($return) );
		
		}
		
		
		//should we save an existing site or create a new one?
		
		if( $_POST['siteID'] == 0 ) {//no siteID provided, creste a new site
		
			//create the new site
			
			$siteID = $this->sitemodel->create($_POST['siteName'], $_POST['pageData']);
								
			
			//all went well
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_save_success1_heading');
			$temp['content'] = $this->lang->line('sites_save_success1_message');
			
			$return['responseCode'] = 1;
			$return['siteID'] = $siteID;
			$return['responseHTML'] = $this->load->view('partials/success', array('data'=>$temp), true);
			
			die( json_encode($return) );
			
		
		} else {//we have a site ID, update existing site
		
			$siteID = $_POST['siteID'];
			
			if( isset($_POST['pagesData']) ) {
			
				$this->sitemodel->update($siteID, $_POST['siteName'], $_POST['pageData'], $_POST['pagesData']);
			
			} else {
			
				$this->sitemodel->update($siteID, $_POST['siteName'], $_POST['pageData']);
			
			}
			
			$return = array();
			
			if( $forPublish == 0 ) {//regular site save
			
				$temp = array();
				$temp['header'] = $this->lang->line('sites_save_success2_heading');
				$temp['content'] = $this->lang->line('sites_save_success2_message');
			
			} elseif( $forPublish == 1 ) {//saving before publishing, requires different message
			
				$temp = array();
				$temp['header'] = $this->lang->line('sites_save_success3_heading');
				$temp['content'] = $this->lang->line('sites_save_success3_message');
			
			}
			
			$return['responseCode'] = 1;
			$return['siteID'] = $siteID;
			$return['responseHTML'] = $this->load->view('partials/success', array('data'=>$temp), true);
			
			die( json_encode($return) );
		
		}		
		
		
		
	
	}
	
	
	function coba($siteID = false)
	{
		echo "sipsip ".$siteID;
		print_r($this->pusaka->get_pages_tree());
	}

	/*
	
		get and retrieve single site data
	
	*/

	
	public function site($siteID) {
			
		$siteData = $this->sitemodel->getSite($siteID);
	
		if( $siteData == false ) {
			
			//site could not be loaded, redirect to /sites, with error message
			
			$this->session->set_flashdata('error', $this->lang->line('sites_site_error1'));
			
			redirect('/panel/builder/site/', 'refresh');
		
		} else {
		
			$this->data['siteData'] = $siteData;
			
			
			//get page data
			$pagesData = $this->pagemodel->getPageData($siteID);
			
			if( $pagesData ) {
			
				$this->data['pagesData'] = $pagesData;
			
			}
			
			
			//collect data for the image library
			
			$user = $this->ion_auth->user()->row();
			
			$userID = $user->id;
			
			$userImages = $this->usermodel->getUserImages( $userID );
			
			if( $userImages ) {
			
				$this->data['userImages'] = $userImages;
			
			}
			
			
			$adminImages = $this->sitemodel->adminImages();
			
			if( $adminImages ) {
			
				$this->data['adminImages'] = $adminImages;
			
			}
			
		
			$this->data['builder'] = true;
			$this->data['page'] = "site";
			$this->template->view('create', $this->data);
		
		}
	
	}
	
	
	
	/*
	
		get and retrieve single site data with ajax
	
	*/
	
	public function siteAjax($siteID = '') {
	
		if( $siteID == '' || $siteID == 'undefined' ) {
		
			//siteID is missing
			
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_siteAjax_error1_heading');
			$temp['content'] = $this->lang->line('sites_siteAjax_error1_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			die( json_encode( $return ) );
		
		}
	
		$siteData = $this->sitemodel->getSite($siteID);
	
		if( $siteData == false ) {
		
			//all did not go well
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_siteAjax_error2_heading');
			$temp['content'] = $this->lang->line('sites_siteAjax_error2_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			echo json_encode( $return );
		
		} else {
			
			//all went well
			$return = array();
			
			$return['responseCode'] = 1;
			$return['responseHTML'] = $this->load->view('partials/sitedata', array('data' => $siteData), true);
			
			echo json_encode( $return );		
		
		}
	
	}
	
	
	/*
		
		updates site details, submitting through ajax
	
	*/
	
	public function siteAjaxUpdate() {
	
		$this->form_validation->set_rules('siteID', 'Site ID', 'required');
		$this->form_validation->set_rules('siteSettings_siteName', 'Site name', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			//all did not go well
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_siteAjaxUpdate_error1_heading');
			$temp['content'] = $this->lang->line('sites_siteAjaxUpdate_error1_message').validation_errors();
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			echo json_encode( $return );
		
		} else {//all good with the data, let's update
		
			$ftpOk = $this->sitemodel->updateSiteData( $_POST );
			
			//all did went well
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_siteAjaxUpdate_success_heading');
			
			if( $ftpOk ) {
			
				$temp['content'] = $this->lang->line('sites_siteAjaxUpdate_success_message1');
			
			} else {
				
				$temp['content'] = $this->lang->line('sites_siteAjaxUpdate_success_message2');
			
			}
			
			$return['responseCode'] = 1;
			$return['responseHTML'] = $this->load->view('partials/success', array('data'=>$temp), true);
			
			if( $ftpOk ) {
				$return['ftpOk'] = 1;
			} else {
				$return['ftpOk'] = 0;
			}
			
			
			//we'll send back the updated site data as well
			$siteData = $this->sitemodel->getSite($_POST['siteID']);
			
			$return['responseHTML2'] = $this->load->view('partials/sitedata', array('data'=>$siteData), true);
			
			$return['siteName'] = $siteData['site']->sites_name;
			$return['siteID'] = $siteData['site']->sites_id;
			
			echo json_encode( $return );
		
		}
		
	
		
	
	}
	
	
	
	/*
		
		gets the content of a saved frame and sends it back to the browser
		
	*/
	
	public function getframe($frameID) {
	
		$frame = $this->sitemodel->getSingleFrame($frameID);
		
		echo $frame->frames_content;
	
	}
	
	
	
	/*
	
		publishes a site via FTP
	
	*/
	
	public function publish($type = 'page') {
	
		$this->load->helper('file');
        $this->load->helper('directory');
		
		//some error prevention first
		
		//siteID ok?
		
		$siteDetails = $this->sitemodel->getSite( $_POST['siteID'] );
		
		if( $siteDetails == false ) {
		
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_publish_error1_heading');
			$temp['content'] = $this->lang->line('sites_publish_error1_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			die( json_encode( $return ) );
		
		}
		
		
		//do we have anythin to publish at all?
		if( !isset( $_POST['item'] ) || $_POST['item'] == '' ) {
		
			//nothing to upload
			
			$return = array();
			
			$temp = array();
			$temp['header'] = $this->lang->line('sites_publish_error2_heading');
			$temp['content'] = $this->lang->line('sites_publish_error2_message');
			
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
			
			die( json_encode( $return ) );
		
		}
		
		
		
		/*
			
			establish FTP connection, needs error reporting
			
		*/
		
		
		$this->load->library('ftp');
		
		$config['hostname'] = $siteDetails['site']->ftp_server;
		$config['username'] = $siteDetails['site']->ftp_user;
		$config['password'] = $siteDetails['site']->ftp_password;
		$config['port'] = $siteDetails['site']->ftp_port;
		
		if( !$this->ftp->connect($config) ) {
			
			//connection details are messed up
			$return = array();
				
			$temp = array();
			$temp['header'] = $this->lang->line('sites_publish_error2_heading');
			$temp['content'] = $this->lang->line('sites_publish_error3_message');
				
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
				
			die( json_encode( $return ) );
			
		}
		
		
		
		
		
		
	
		
		/* 
			
			uploading
		
		*/
		
		
		
		
		if( $type == 'asset' ) {//asset publishing
		
			set_time_limit(0);//prevent timeout
            
            if( $_POST['item'] == 'images' ) {
            
                //echo './elements/'.$_POST['item'].'/<br>';
                
                //create the /imaged folder?
                if( !$this->ftp->list_files( $siteDetails['site']->ftp_path."/images/" ) ) {
                 
                    $this->ftp->mkdir( $siteDetails['site']->ftp_path."/images/" );
                    
                }
                
                
                $dirMap = directory_map( './elements/images/', 2 );
                
                foreach( $dirMap as $key => $entry ) {
                 
                    if( is_array($entry) ) {
                        
                        //folder, do all but take special care of /uploads
                        
                        if( $key != 'uploads' ) {
                            
                            $this->ftp->mirror('./elements/images/'.$key."/", $siteDetails['site']->ftp_path."/images/".$key."/");
                            
                        } else {//take special care of the uploads folder
                            
                            $user = $this->ion_auth->user()->row();
                            $userID = $user->id;
                            
                            $uploadsMap = directory_map( './elements/images/uploads/', 1 );
                            
                            foreach( $uploadsMap as $userIDFolder ) {
                                
                                if( $userIDFolder == $userID ) {
                                    
                                    //echo $userIDFolder."\n";
                                    
                                    //create the /imaged folder?
                                    if( !$this->ftp->list_files( $siteDetails['site']->ftp_path."/images/uploads/" ) ) {
                 
                                        $this->ftp->mkdir( $siteDetails['site']->ftp_path."/images/uploads/" );
                    
                                    }
                                    
                                    $this->ftp->mirror('./elements/images/uploads/'.$userIDFolder."/", $siteDetails['site']->ftp_path."/images/uploads/".$userIDFolder."/");
                                    
                                }
                                
                            }
                            
                        }
                        
                        
                    } else {
                     
                        //file
                        $sourceFile = '/elements/images/'.$entry;
                        $destinationFile = $siteDetails['site']->ftp_path."/images/".$entry;
                        
                        //echo $sourceFile."\n";
                        //echo $_SERVER['DOCUMENT_ROOT'].$sourceFile."\n";
                        
                        $this->ftp->upload('.'.$sourceFile, $destinationFile);
                        
                    }
                    
                }
                
            } else {
		
                $this->ftp->mirror('./elements/'.$_POST['item'].'/', $siteDetails['site']->ftp_path."/".$_POST['item']."/");
                
            }
		
		} elseif( $type == 'page' ) {//page publishing
		
			//create temp files
						
			//check to make sure the /tmp folder is writable
				
			if( !is_writable('./tmp/') ) {
				
				$return = array();
					
				$temp = array();
				$temp['header'] = $this->lang->line('sites_publish_error2_heading');
				$temp['content'] = $this->lang->line('sites_publish_error4_message');
					
				$return['responseCode'] = 0;
				$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
					
				die( json_encode( $return ) );
				
			}
			
			
			//get page meta
			$pageMeta = $this->pagemodel->getSinglePage($_POST['siteID'], $_POST['item']);
			
			if( $pageMeta ) {
			
				//insert title, meta keywords and meta description
				
				$meta = '<title>'.$pageMeta->pages_title.'</title>'."\r\n";
				$meta .= '<meta name="description" content="'.$pageMeta->pages_meta_description.'">'."\r\n";
				$meta .= '<meta name="keywords" content="'.$pageMeta->pages_meta_keywords.'">';
											
				$pageContent = str_replace('<!--pageMeta-->', $meta, $_POST['pageContent']);
				
				//insert header includes;
				
				$pageContent = str_replace("<!--headerIncludes-->", $pageMeta->pages_header_includes, $pageContent);		
			
			} else {
			
				$pageContent = $_POST['pageContent'];
				
			
			}
			
						
			if ( ! write_file('./tmp/'.$_POST['item'].".html", $pageContent)) {
				
				//echo 'Unable to write the file';
				
			} else {
				     
				//echo 'File written!';
				
			}
						
			
			//upload temp files
			
			set_time_limit(0);//prevent timeout
			$this->ftp->mirror('./tmp/', $siteDetails['site']->ftp_path."/");
				
				
			//remove all temp fiels
				
			delete_files('./tmp/');
				
					
		}
		
		
		//all went well
		$return = array();
				
		$return['responseCode'] = 1;
		
		die( json_encode($return) );
		
	
	}
	
	
	
	/*
		
		exports a site
	
	*/
	
	public function export() {
        
        $user = $this->ion_auth->user()->row();
        $userID = $user->id;
        
	
		$zip = new ZipArchive();
		
		$zip->open("./tmp/".$this->config->item('export_fileName'), ZipArchive::CREATE);
		
		
		//add folder structure
		
		//prep path to assets array
		
		$temp = explode("|", $this->config->item('export_pathToAssets'));
		
		foreach( $temp as $thePath ) {
		
			// Create recursive directory iterator
			$files = new RecursiveIteratorIterator(
		    	new RecursiveDirectoryIterator( $thePath ),
		    	RecursiveIteratorIterator::LEAVES_ONLY
			);
		
			foreach ($files as $name => $file) {
			
				if( $file->getFilename() != '.' && $file->getFilename() != '..' ) {
		
		    		// Get real path for current file
		    		$filePath = $file->getRealPath();
		    
		    		$temp = explode("/", $name);
		    
		    		array_shift( $temp );
		    
		    		$newName = implode("/", $temp);
                    
                    if( $thePath == 'elements/images' ) {
                 
                        //check if this is a user file
                        
                        if ( strpos($file,'/uploads') !== false ) {
                            
                            if( strpos($file,'/uploads/'.$userID.'/') !== false ) {
                             
                                // Add current file to archive
		    		            $zip->addFile($filePath, $newName);
                                
                                //echo $filePath."<br>";
                                
                            }
                        
                        } else {
                         
                            // Add current file to archive
		    		        $zip->addFile($filePath, $newName);
                            
                            //echo $filePath."<br>";
                            
                        }
                    
                    } else {
		
		    		    // Add current file to archive
		    		    $zip->addFile($filePath, $newName);
                        
                        //echo $filePath."<br>";
                        
                    }
		    	
		    	}
		    
			}
		
		}
        
        //die('');
		
		
		
		foreach( $_POST['pages'] as $page=>$content ) {
		
			//get page meta
			$pageMeta = $this->pagemodel->getSinglePage($_POST['siteID'], $page);
			
			if( $pageMeta ) {
			
				//insert title, meta keywords and meta description
				
				$meta = '<title>'.$pageMeta->pages_title.'</title>'."\r\n";
				$meta .= '<meta name="description" content="'.$pageMeta->pages_meta_description.'">'."\r\n";
				$meta .= '<meta name="keywords" content="'.$pageMeta->pages_meta_keywords.'">';
								
				$pageContent = str_replace('<!--pageMeta-->', $meta, $content);
				
				//insert header includes;
				
				$pageContent = str_replace("<!--headerIncludes-->", $pageMeta->pages_header_includes, $pageContent);
				
				
				//remove frameCovers
				
				$pageContent = str_replace('<div class="frameCover" data-type="video"></div>', "", $pageContent);
			
			} else {
			
				$pageContent = $content;
			
			}
		
			$zip->addFromString($page.".html", $_POST['doctype']."\n".stripslashes($pageContent));
			
			//echo $content;
		
		}
		
		//$zip->addFromString("testfilephp.txt" . time(), "#1 This is a test string added as testfilephp.txt.\n");
		//$zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
		
		$zip->close();
		
		
		$yourfile = $this->config->item('export_fileName');
		
		$file_name = basename($yourfile);
		
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Content-Length: " . filesize("./tmp/".$yourfile));
		
		readfile("./tmp/".$yourfile);
		
		unlink('./tmp/'.$yourfile);
		
		exit;
	
	}
	
	
	
	/*
	
		moves a single site to the trash bin
	
	*/
	
	public function trash($siteID = '') {
	
		if( $siteID == '' || $siteID == 'undefined' ) {
		
			$return = array();
				
			$temp = array();
			$temp['header'] = $this->lang->line('sites_trash_error1_heading');
			$temp['content'] = $this->lang->line('sites_trash_error1_message');
				
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
				
			die( json_encode( $return ) );
		
		}
		
		
		
		//all good, move to trash
		
		$this->sitemodel->trash( $siteID );
		
		$return = array();
			
		$temp = array();
		$temp['header'] = $this->lang->line('sites_trash_success_heading');
		$temp['content'] = $this->lang->line('sites_trash_success_message');
			
		$return['responseCode'] = 1;
		$return['responseHTML'] = $this->load->view('partials/success', array('data'=>$temp), true);
			
		die( json_encode( $return ) );
	
	}
	
	
	
	/*
	
		updates page meta data via ajax
	
	*/
	
	public function updatePageData() {
	
		if( $_POST['siteID'] == '' || $_POST['siteID'] == 'undefined' || !isset( $_POST ) ) {
		
			$return = array();
				
			$temp = array();
			$temp['header'] = $this->lang->line('sites_updatePageData_error1_heading');
			$temp['content'] = $this->lang->line('sites_updatePageData_error1_message');
				
			$return['responseCode'] = 0;
			$return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
				
			die( json_encode( $return ) );
		
		}
		
		//update page data
		$this->pagemodel->updatePageData( $_POST );
		
		$return = array();
		
		//return page data as well
		$pagesData = $this->pagemodel->getPageData($_POST['siteID']);
		
		if( $pagesData ) {
		
			$return['pagesData'] = $pagesData;
		
		}
			
		$temp = array();
		$temp['header'] = $this->lang->line('sites_updatePageData_success_heading');
		$temp['content'] = $this->lang->line('sites_updatePageData_success_message');
			
		$return['responseCode'] = 1;
		$return['responseHTML'] = $this->load->view('partials/success', array('data'=>$temp), true);
			
		die( json_encode( $return ) );
	
	}
 
}

/* End of file sites.php */
/* Location: ./application/controllers/sites.php */