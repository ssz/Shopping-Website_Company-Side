<?php

    class Account extends CI_Controller{
    
        public function __construct(){
		    parent::__construct();
		    $this->load->model('my_model');
		}
		
		// display default page
		function index() {
		
			if ($this->session->userdata('cloginsuccess') && $this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                // Every page has 15 minutes to expire  
                redirect(site_url('account/clogout'));
            }

			$this->session->set_userdata('start', time());
            //$sql = "SELECT specialsale.specialID, specialsale.productID, product.productname, product.price, specialsale.discount, specialsale.startday, specialsale.startmon, specialsale.startyear, specialsale.endday, specialsale.endmon, specialsale.endyear FROM product, specialsale WHERE product.productID=specialsale.productID";
            $td=date("j",time());
            $tm=date("n",time());
            $ty=date("Y",time());
            
            $data['prodcutcategory']=$this->my_model->get_category();
            $data1['specialsale']=$this->my_model->get_specialsale($td, $tm, $ty);              
            
            $this->load->view('head_view', $data);    
            $this->load->view('getspecialsale_view', $data1);
            $this->load->view('end_view');        
		}
		
		// login and redirect to previous page
		function clogin_new() {
			
            if(!$this->session->userdata('url') || $this->input->get('url')){
                $url = $this->input->get('url');
            }else{
			    $url = $this->session->userdata('url');
			}
			
		    if ($url=='http://cs-server.usc.edu:8111/HW4/CodeIgniter/index.php/account/clogout'){
			    $url = base_url().'index.php';
		    }
		    $this->session->set_userdata('cloginsuccess', false);
		    $this->form_validation->set_rules('cusername', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('cpassword', 'Password', 'trim|required|xss_clean|callback_check_login');    
		    
		    if($this->form_validation->run() == FALSE) {
		    	$data['prodcutcategory']=$this->my_model->get_category(); 
            	$this->load->view('head_view', $data);    
		    	$this->load->view('cinlogin_view');
            	$this->load->view('end_view');        
		    } else {
		    	redirect($url);    
		    }
		}
		
		// login callback function set session variables and save cart of cookies into database
		function check_login($cpassword) {
			$cusername=$this->input->post('cusername');
			$row = $this->my_model->get_account($cusername,$cpassword);
			
			if($row) {
				$this->session->set_userdata('cusername', $cusername);
                $this->session->set_userdata('cloginsuccess', true);
                $this->session->set_userdata('start', time());
                $this->session->set_userdata('customerid', $row['customerID']);
                $customerid = $this->session->userdata('customerid');
                
                //if customer has a cart before login, save the cart into database and clear the cookie
                if(isset($_COOKIE['cart'])){	
                	foreach($_COOKIE['cart'] as $productID => $productquantity){
                        
                        $row1 = $this->my_model->get_cart($customerid, $productID);
                        // if there exists a same prodcut in the cart update it, or insert it into the cart
                        if ($row1) {
                        	$cartQty=$row1['productquantity']+$productquantity;
                    	    if($cartQty > 8) {
                    		    $cartQty = 8;
                    	    }
                    	    if (!$this->my_model->update_cart($cartQty, $customerid, $productID)) {
                    	    	die('Cannot update cart table.');
                    	    }
                        } else {
                    	    if (!$this->my_model->insert_cart($customerid, $productID, $productquantity)) {
                    	    	die('Cannot insert new products into cart table.');
                    	    }                        
                        }
                    }   
                        
                    foreach($_COOKIE["cart"] as $productID => $productquantity){
                        setcookie("cart[$productID]", "", time()-900);
                    }
                }
                return true;
			} else {
				$this->form_validation->set_message('check_login', 'Invalid username or password');
				return false;
			}
		}
		
		function clogout(){
		    $this->session->sess_destroy();
		    redirect(site_url());
	    }
	    
	    // search function 
	    function search(){
			if ($this->session->userdata('cloginsuccess') && $this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                // Every page has 15 minutes to expire  
                redirect(site_url('account/clogout'));
            } else {

				$skey = $this->input->get('skey');
				$categID = $this->input->get('categ');
			
				$data['result'] = $this->my_model->search_all($skey, $categID);
				$data['specialsale'] = $this->my_model->search_specialsale($skey, $categID);
				$data['nonspecialsale'] = $this->my_model->search_nonspecialsale($skey, $categID);
			
				$this->load->view('searchProduct_view', $data);
			}
	    }
	    
	    function displayproduct($productID) {
			if ($this->session->userdata('cloginsuccess') && $this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                // Every page has 15 minutes to expire  
                redirect(site_url('account/clogout'));
            } else {
            
            	$data1['prodcutcategory']=$this->my_model->get_category(); 
             	$data['product'] = $this->my_model->get_product($productID);
             	$data['discountinfo'] = $this->my_model->get_discountinfo($productID); 
             	$res_recom = $this->my_model->get_recommend($productID);
             	
             	$first = $res_recom['first'];
             	$second = $res_recom['second'];
             	
             	$data['row_recom_first'] = $this->my_model->get_product($first);
             	$data['row_recom_second'] = $this->my_model->get_product($second);	
             	
             	$this->load->view('head_view', $data1); 
				$this->load->view('product_view', $data);
				$this->load->view('end_view');        
			}	    	
	    }
	    
	    function accountProfile(){
	        if ($this->session->userdata('cloginsuccess') && $this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                // Every page has 15 minutes to expire  
                redirect(site_url('account/clogout'));
            }
            
            if(time()-$this->session->userdata('start')>15 * 60){
	            redirect(site_url('account/clogout'));
	        }
	        $this->session->set_userdata('start',time());
	        $data['prodcutcategory']=$this->my_model->get_category(); 
            $this->load->view('head_view', $data); 
	        $this->load->view('account_view');
	        $this->load->view('end_view');
	    }
	    
	    
	    function addProfile(){
            
            //$customerid=$this->session->userdata('customerid');
            

			
		//	$this->load->library('form_validation');
            $this->form_validation->set_rules('newusername', 'Username', 'required|htmlspecialchars|xss_clean|is_unique[customers.username]');
            $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|matches[conpassword]|htmlspecialchars');
            $this->form_validation->set_rules('conpassword', 'Password Confirmation', 'trim|required|htmlspecialchars');
            $this->form_validation->set_rules('newfirstname', 'First name', 'trim|alpha|required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('newlastname', 'Last name', 'trim|alpha|required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('birth', 'Birth', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('cardnum', 'Card Number', 'required|htmlspecialchars|xss_clean|is_natural|exact_length[16]');
            $this->form_validation->set_rules('cardtype', 'Card Type', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('expire', 'Expire', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipadd', 'Ship Address', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('billadd', 'Bill Address', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|htmlspecialchars|xss_clean');
            //$this->form_validation->set_rules('phone', 'Phone', 'required|htmlspecialchars|xss_clean|exact_length[10]|is_natural')
            
            $this->form_validation->set_rules('phone', 'Phone', 'required|htmlspecialchars|xss_clean|is_natural|exact_length[10]');
            
            
            if($this->form_validation->run()==false){
            	$data['prodcutcategory']=$this->my_model->get_category(); 
            	$this->load->view('head_view', $data);
				$this->load->view('addProfile_view');
				$this->load->view('end_view');
				
			}else{
			    
			    $newusername=$this->input->post('newusername');
            	$newpassword=$this->input->post('newpassword');
            	$conpassword=$this->input->post('conpassword');
            	$newfirstname=$this->input->post('newfirstname');
            	$newlastname=$this->input->post('newlastname');
            	$birth=$this->input->post('birth'); 
            	$cardnum=$this->input->post('cardnum'); 
            	$cardtype=$this->input->post('cardtype');
            	$expire=$this->input->post('expire');
            	$shipadd=$this->input->post('shipadd'); 
            	$billadd=$this->input->post('billadd');
            	$email=$this->input->post('email'); 
            	$phone=$this->input->post('phone');
			    
			    
				$result = $this->my_model->insert_profile($newusername, $newpassword, $newfirstname, $newlastname, $birth, $cardnum, $cardtype, $expire, $shipadd, $billadd, $email, $phone); 

			    if ($result) {
			    	redirect(site_url('account/clogin_new'));
			    } else {
			        $data['prodcutcategory']=$this->my_model->get_category(); 
            		$this->load->view('head_view', $data);
					$this->load->view('addProfile_view');
					$this->load->view('end_view');
			    }
			}
		}
			
		function updateProfile(){
            
            $customerid=$this->session->userdata('customerid');
            
            $this->form_validation->set_rules('newusername', 'Username', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|matches[conpassword]|htmlspecialchars');
            $this->form_validation->set_rules('conpassword', 'Password Confirmation', 'trim|required|htmlspecialchars');
            $this->form_validation->set_rules('newfirstname', 'First name', 'trim|alpha|required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('newlastname', 'Last name', 'trim|alpha|required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('birth', 'Birth', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('cardnum', 'Card Number', 'required|htmlspecialchars|xss_clean|is_natural|exact_length[16]');
            $this->form_validation->set_rules('cardtype', 'Card Type', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('expire', 'Expire', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipadd', 'Ship Address', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('billadd', 'Bill Address', 'required|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|htmlspecialchars|xss_clean');
            //$this->form_validation->set_rules('phone', 'Phone', 'required|htmlspecialchars|xss_clean|exact_length[10]|is_natural')
            
            $this->form_validation->set_rules('phone', 'Phone', 'required|htmlspecialchars|xss_clean|is_natural|exact_length[10]');
            
            
            if($this->form_validation->run()==false){
            	$data['prodcutcategory']=$this->my_model->get_category();
            	$data1['profile']=$this->my_model->get_profile($customerid);
            	$this->load->view('head_view', $data);
				$this->load->view('updateProfile_view', $data1);
				$this->load->view('end_view');
				
			}else{
			    
			    $newusername=$this->input->post('newusername');
            	$newpassword=$this->input->post('newpassword');
            	$conpassword=$this->input->post('conpassword');
            	$newfirstname=$this->input->post('newfirstname');
            	$newlastname=$this->input->post('newlastname');
            	$birth=$this->input->post('birth'); 
            	$cardnum=$this->input->post('cardnum'); 
            	$cardtype=$this->input->post('cardtype');
            	$expire=$this->input->post('expire');
            	$shipadd=$this->input->post('shipadd'); 
            	$billadd=$this->input->post('billadd');
            	$email=$this->input->post('email'); 
            	$phone=$this->input->post('phone');
			    
			    
				$result = $this->my_model->update_profile($customerid, $newusername, $newpassword, $newfirstname, $newlastname, $birth, $cardnum, $cardtype, $expire, $shipadd, $billadd, $email, $phone); 

			    if ($result) {
			    	redirect(site_url('account/accountProfile'));
			    } else {
			        $data['prodcutcategory']=$this->my_model->get_category();
            		$data1['profile']=$this->my_model->get_profile($customerid);
            		$this->load->view('head_view', $data);
					$this->load->view('updateProfile_view',$data1);
					$this->load->view('end_view');
			    }
			}
		}
			
		
		
        function addCart(){
            $productID=$this->input->get('productID');
	        $qty=$this->input->get('quantity');
	        $customerid= $this->session->userdata('customerid');
	        
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15*60)){
				//Every page has 15 minutes to expire 
				$this->clogout();
			}
			
			if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->set_userdata('start', time());
				//Find if this product is already in cart. Store to table.
                $row=$this->my_model->cart_productquantity($customerid, $productID);
                //$this->load->view('cart_view');
                if($row){
                    $qty=$qty+$row['productquantity'];
                    //print_r($qty);
                    //mysql_query("UPDATE cart SET productquantity='$qty' WHERE customerID='$customerid' AND productID='$productID'");  
                    $this->my_model->updatecart_pqty($customerid, $productID, $qty); 
                }else{
                    //$sql_action = "INSERT INTO cart (customerID, productID, productquantity) VALUES ('$customerid', '$productID', '$qty')";
                    $this->my_model->insertcart($customerid, $productID, $qty);
                }
            }
			
			if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
                //Not login. Store to cookie. period of validity is one day.
                $expire=time()+60*60*24;
                if(isset($_COOKIE["cart"][$productID])){
			        $qty = $qty + $_COOKIE["cart"][$productID];
			        setcookie("cart[$productID]",$qty,$expire);
		        }else{
			        setcookie("cart[$productID]",$qty,$expire);
		        }
		        /*$this->load->helper('cookie');
		        if($this->input->cookie('cart')){
		            $qty = $qty + $_COOKIE["cart"][$productID];
		        }*/
	        }
	        redirect(site_url('account/displayCart'));
	        //$this->displayCart();
        }
        
        
         function displayCart(){
            $customerid = $this->session->userdata('customerid');
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15*60)){
				//Every page has 15 minutes to expire 
				$this->clogout();
			}
			
			if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->set_userdata('start', time());
				
				$deletepid=$this->input->post('delete');    ////check here 	
                if($this->input->post('delete')){
        	        foreach($deletepid as $delete){
        	            $query=$this->my_model->cartdelete($customerid, $delete);
        		        //$sql_del = "DELETE FROM cart WHERE productID = '$delete' AND customerID='$customerid'";
        	        }   
                }
                
                //retrieve and display from table
                $datac['cart_cusid']=$this->my_model->cart_cusid($customerid); //$sql= "SELECT * FROM cart WHERE customerID=$customerid";
                $data['prodcutcategory']=$this->my_model->get_category();
                
                $this->load->view('head_view', $data);
                $this->load->view('displayCart_view', $datac);
                $this->load->view('end_view');
               }
			
			if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
                //Not login. Store to cookie. period of validity is one day.
                
                $deletepid = $this->input->post('delete');	
                if($this->input->post('delete')){
        	        foreach($deletepid as $delete){
        		        //$this->input->set_cookie("cart[$delete]","",time()-900); 
        		        setcookie("cart[$delete]","",time()-900);      
                    }
                    redirect(site_url('account/displayCart'));
                }
                $data['prodcutcategory']=$this->my_model->get_category();
                
                $this->load->view('head_view', $data);
                $this->load->view('displayCart_view');   
                $this->load->view('end_view');
                //$this->load->view('cinlogin_view');          
       
            }
           
        } 
        
        
        function checkout(){
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                //Every page has 15 minutes to expire 
				$this->clogout();
            }
    
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->set_userdata('start', time());
				$customerid = $this->session->userdata('customerid');
				$datacheckout['product_cart'] = $this->my_model->product_cart($customerid);
                $datacheckout['cus_id']=$this->my_model->cus_id($customerid);
				$data['prodcutcategory']=$this->my_model->get_category();
				
				$this->load->view('head_view', $data);
                $this->load->view('checkout_view', $datacheckout);
                $this->load->view('end_view');
            }
            
            if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
                //Not login. Store to cookie. period of validity is one day.
                $this->session->set_userdata('url', 'http://cs-server.usc.edu:8111/HW4/CodeIgniter/index.php/account/checkout');
                $_SESSION['url']="http://cs-server.usc.edu:8111/HW3/checkout.php";
                $this->clogin_new();
                 
            }
        }
        
        
        function myorders() {
        
        	if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                //Every page has 15 minutes to expire 
				$this->clogout();
            }
    
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->userdata('start', time());
				$customerid = $this->session->userdata('customerid');
				
				$data['prodcutcategory']=$this->my_model->get_category();
				$data1['orderlist']=$this->my_model->get_orderlist($customerid);
				
				$this->load->view('head_view', $data);
                $this->load->view('myorders_view', $data1);
                $this->load->view('end_view');
            }
        
        }
        
        function displayOrder($orderid) {
		
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                //Every page has 15 minutes to expire 
				$this->clogout();
            }
    
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->userdata('start', time());
				$customerid = $this->session->userdata('customerid');
				
				$data['prodcutcategory']=$this->my_model->get_category();
				
				$data1['orderid'] = $orderid;
				$data1['order'] = $this->my_model->get_order($customerid, $orderid);
				$data1['orderinfo'] = $this->my_model->get_orderinfo($orderid);
				//$sql ="SELECT orderdate, totalpay FROM orderlist WHERE orderID = '$orderid' AND customerID = '$customerid'";

				//$sql_sel = "SELECT p.productID, p.productname, o.productquantity, o.price FROM product p, orders o WHERE p.productID = o.productID AND o.orderID = '$orderid' ";		

				$this->load->view('head_view', $data);
                $this->load->view('displayOrder_view', $data1);
                $this->load->view('end_view');
            }
            
            if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
                //Not login. Store to cookie. period of validity is one day.
                $this->clogin_new();
            }
		}
        
        function order() {
		
			if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')>15 * 60)){
                //Every page has 15 minutes to expire 
				$this->clogout();
            }
    
            if($this->session->userdata('cloginsuccess')==true && (time()-$this->session->userdata('start')<=15*60)){
				//login and no timeout
				$this->session->userdata('start', time());
				$customerid = $this->session->userdata('customerid');
				$totalPrice = $this->input->post('ordertotalPrice');
				

				
				if ($totalPrice) {
					$today=date("Y-m-d",time());
					
					//insert into orderlist and get orderID
        			mysql_query("BEGIN");
					$res = $this->my_model->insert_orderlist($customerid, $today, $totalPrice);
					if(!$res) {
        				die("Cannot insert into orderlist!");
        			}
        			$last = $this->my_model->get_lastid();
        			if (!$last) {
        				die("Cannot get the last order ID.");
					}
					$orderid = $last['LAST_INSERT_ID()'];
       				mysql_query("COMMIT"); 
       				
       				//insert into orders
       				
       				$cartinfo = $this->my_model->get_cartinfo($customerid);
       				
       				if(!$cartinfo) {
        				die("Cannot get info from cart!");
        			}
       				 
       				foreach($cartinfo as $row) {
        				$productid = $row['productID'];
        				$qty = $row['productquantity'];
        				
        				$row2 = $this->my_model->get_discount($productid);
        				
        				$row3 = $this->my_model->get_priceinfo($productid);
			
						if($row2){
							$unitPrice = round($row3['price']*(1-$row2['discount']*0.01),2);
						}else{
							$unitPrice = $row3['price'];
						}
						
						$Price = round($unitPrice * $row['productquantity'],2);
						
						$res_in = $this->my_model->insert_orders($orderid, $productid, $qty, $Price);
        				if(!$res_in) {
        					die("Cannot insert into order!");
        				}
        			} // end of foreach
        			
        			$res_del = $this->my_model->delete_cartinfo($customerid);
        			        
        			if(!$res_del) {
        				die("Cannot delete info from cart!");
        			}
				}
				redirect(site_url('account/myorders'));
            }
            
            if(!$this->session->userdata('cloginsuccess') || $this->session->userdata('cloginsuccess')==false){
                //Not login. Store to cookie. period of validity is one day.
                $this->clogin_new();
            }
		
		}
	    
		/*
		function clogin(){
		    $url = $this->input->get('url');
		    if ($url=='http://cs-server.usc.edu:8111/HW4/CodeIgniter/index.php/account/clogout'){
			    $url = base_url().'index.php';
		    }

		    $cusername=$this->input->post('cusername');
		    $cpassword=$this->input->post('cpassword');
            $errmsg="";
            $this->session->set_userdata('cloginsuccess', false);
        
            $this->load->library('form_validation');
            $this->form_validation->set_rules('cusername', 'Username', 'required|xss_clean');
            $this->form_validation->set_rules('cpassword', 'Password', 'required');    

            if(strlen($cusername)==0){
                $errmsg='Invalid Login';
            }   
            if(strlen($cpassword)==0){
                $errmsg='Invalid Login';
            }
            if(strlen($cusername)==0 && strlen($cpassword)==0){
                $errmsg=''; 
            }
            //go to DB to validate when both exist.
            if(strlen($cusername)>0 && strlen($cpassword)>0){
                if ($this->form_validation->run() == FALSE){
                    $errmsg='Validation False';
                }   
                if(strlen($errmsg)>0){
                    $this->load->view('cinlogin_view',$errmsg);
                }else{
                
                    $row = $this->my_model->get_account($cusername,$cpassword);
                    if (!$row){
				        $errmsg = "Invalid Login.";
			        }else{

                        //echo "good login!";                
                        $this->session->set_userdata('cusername', $cusername);
                        $this->session->set_userdata('cloginsuccess', true);
                        $this->session->set_userdata('start', time());
                        //Ending a session in 15 minutes from the starting time.
                        //$_SESSION['expire']=$_SESSION['start'] + (15 * 60); 
                        $this->session->set_userdata('customerid', $row['customerID']);
			           
                        if(isset($_COOKIE['cart'])){	
                            foreach($_COOKIE['cart'] as $productID => $productquantity){
                                $res3=mysql_query("SELECT * FROM cart WHERE customerID='$customerid' AND productID='$productID'"); ///////zhelizhelizhelizheli ...><...
                                //echo "SELECT * FROM cart WHERE customerID='$customerid' AND productID='$productID'";
                                if(mysql_num_rows($res3)) {
                    	            $row3 = mysql_fetch_assoc($res3);
                    	            $cartQty=$row3['productquantity']+$productquantity;
                    	            if($cartQty > 8) {
                    		            $cartQty = 8;
                    	            }
                    	            $sqlcart = "UPDATE cart SET productquantity='$cartQty' WHERE customerID='$customerid' AND productID='$productID'"; ///////zhelizhelizhelizheli ...><...
                    	            if(!$rescart = mysql_query($sqlcart)){ ///////zhelizhelizhelizheli ...><...
                                        die('Cannot update cart table.');
                                    }	
                                }else {
                    	            $sqlcart = "INSERT INTO cart (customerID, productID, productquantity) VALUES ('$customerid', '$productID', '$productquantity')"; ///////zhelizhelizhelizheli ...><...
                    	            //echo $sqlcart;
                                    if(!($rescart = mysql_query($sqlcart))){ ///////zhelizhelizhelizheli ...><...
                                        die('Cannot insert new products into cart table.');
                                    }   
                                }
                            }   
                        
                            foreach($_COOKIE["cart"] as $productID => $productquantity){
                                setcookie("cart[$productID]", "", time()-900);
                            }
                        }
                    
                        $this->session->set_userdata('url', $url);
                        redirect($url);  
                 
                        $this->load->view('welcome_message');      
                    }
                }
            }else{
            
                $data['errmsg'] = $errmsg;
                $this->load->view('cinlogin_view', $data);      
                //require 'cinlogin_view.php';
            }
        }
        */

        
    
    /*
        function addProfile(){
            $this->session->userdata(newusername);
            $newusername=$this->input->post('newusername');
            $newpassword=$this->input->post('newpassword');
            $conpassword=$this->input->post('conpassword');
            $newfirstname=$this->input->post('newfirstname');
            $newlastname=$this->input->post('newlastname');
            $birth=$this->input->post('birth'); 
            $cardnum=$this->input->post('cardnum'); 
            $cardtype=$this->input->post('cardtype');
            $expire=$this->input->post('expire');
            $shipadd=$this->input->post('shipadd'); 
            $billadd=$this->input->post('billadd');
            $email=$this->input->post('email'); 
            $phone=$this->input->post('phone');
			
			if(empty($newusername)){
			    $usernameError = "Username Invalid.";
			}else{
			    $usernameError = "";
		    }
			if(empty($newpassword)){
				$passwordError = "Password Invalid.";
			}else{
			    $passwordError = "";
		    }
		    if(empty($conpassword)){
				$conpasswordError = "Confirm Password Invalid.";
			}else{
			    $conpasswordError = "";
		    }
		    if($conpassword!=$newpassword){
		        $difError="Confirm Password is different.";
		    }else{
		        $difError="";
		    }
		    if(empty($newfirstname) || is_numeric($newfirstname)){
		        $firstnameError = "Firstname Invalid";
		    }else{
		        $firstnameError="";
		    }
		    if(empty($newlastname) || is_numeric($newlastname)){
		        $lastnameError = "Lastname Invalid";
		    }else{
		        $lastnameError="";
		    }
		    if(empty($birth)){
				$birthError = "Birth Invalid.";
			}else{
			    $birthError = "";
		    }
		    if ((strlen($cardnum) > 0 && (!is_numeric($cardnum))) || strlen($cardnum)!=16 || $cardnum < 0 || empty($cardnum)){
		        $cardnumError = "Card Number Invalid. ";
	        }else{
		        $cardnumError = "";
	        }
	        if($cardtype!="visa" && $cardtype!="master" && $cardtype!="discover"&& $cardtype!="american"){
		        $cardtypeError = "Card Type Invalid";
		    }else{
		        $cardtypeError = "";
		    }
		    $today = date('m/d', time());
	        if(empty($expire) || strtotime($expire) < strtotime($today)){
				$expireError = "Expire Date Invalid.";
			}else{
			    $expireError = "";
		    }
		    if(empty($shipadd)){
				$shipaddError = "Ship Address Invalid.";
			}else{
			    $shipaddError = "";
		    }
		    if(empty($billadd)){
				$billaddError = "Bill Address Invalid.";
			}else{
			    $billaddError = "";
		    }
	        if(empty($email)){
	            $emailError = "Email Invalid.";
	        }else{
	            $emailError="";
	        }
	        if(empty($phone) || !is_numeric($phone) || $cardnum < 0 || strlen($phone)!=10){
	            $phoneError = "Phone Invalid.";
	        }else{
	            $phoneError="";
	        }  
            
            //if (strlen($newemployeeID) == 0 && strlen($newusername) == 0 && strlen($newpassword) == 0 && strlen($newfirstname) == 0 && strlen($newlastname) == 0 && strlen($newage) == 0 && strlen($newusertype) == 0 && strlen($newpayment) == 0) {
		    if (strlen($newusername) == 0 && strlen($newpassword) == 0 && strlen($newfirstname) == 0 && strlen($newlastname) == 0 && strlen($birth) == 0 && strlen($cardnum) == 0 && strlen($cardtype) == 0 && strlen($expire) == 0 && strlen($shipadd) == 0 && strlen($billadd) == 0 && strlen($email) == 0 && strlen($phone) == 0) {   
		        //$employeeIDError = $usernameError = $passwordError = $usertypeError = $ageError = $payError = "";
		        $usernameError = $passwordError = $conpasswordError = $difError = $firstnameError = $lastnameError = $birthError = $cardnumError = $cardtypeError = $expireError = $shipaddError = $billaddError = $emailError = $phoneError = "";
		        $ini = true;
		    }else{
		        $ini = false;
		    }

		    //if ($employeeIDError=="" && $usernameError == "" && $passwordError == "" && $usertypeError == "" && $ageError == "" && $payError == "" && $ini == false){
		    if ($usernameError == "" && $passwordError == "" && $conpasswordError == "" && $difError == "" && $firstnameError == "" && $lastnameError == "" && $birthError == "" && $cardnumError == "" && $cardtypeError == "" && $expireError == "" && $shipaddError == "" && $billaddError == "" && $emailError == "" && $phoneError== "" && $ini == false){	
		       // $res = mysql_query("INSERT INTO customers (username, password, firstName, lastName, birth, email, phone, cardNumber, cardType, expireDate, billAdd, shipAdd) VALUES ('$newusername', password('$newpassword'), '$newfirstname', '$newlastname','$birth', '$email', '$phone', '$cardnum', '$cardtype', '$expire', '$billadd', '$shipadd')");  
			    $row = $this->account_model->; ///////zhelizhelizhelizheli ...><...
			    if(!$row){
				    die('Cannot add new account.');
			    }else{
			        echo"<p>Successfully create a new user account.</p>";  
			        header("Location: clogin.php"); 
	            }            
	        }else{
	            echo "<br><br><p class='err'>$usernameError $passwordError $conpasswordError $difError $firstnameError $lastnameError $birthError $cardnumError $cardtypeError $expireError $shipaddError $billaddError $emailError $phoneError</p>";  ///////zhelizhelizhelizheli ...><...
	        }
        
        }
        
        
        function updateProfile(){
        
        }
*/

}
?>