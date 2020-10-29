<?php

class My_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}
	
	/*--- login functionality ---*/
	// login query
	function get_account($username,$password)
	{
		settype($username, "string");
		settype($password, "string");
		
		//SELECT customerID FROM customers WHERE username='$cusername' and password=password('$cpassword')
		$query = $this->db->query("SELECT customerID FROM customers WHERE username=? and password=password(?)", array($username,$password));
		return $query->row_array();
	}
	
	// get a specific product info in a customer's cart
	function get_cart($customerid, $productid) {
		$query = $this->db->query("SELECT * FROM cart WHERE customerID='$customerid' AND productID='$productid'");
		return $query->row_array();
	}
	
	// update a specific prodcut qty in a customer's cart
	function update_cart($cartQty, $customerid, $productID) {
		
		$query = $this->db->query("UPDATE cart SET productquantity='$cartQty' WHERE customerID='$customerid' AND productID='$productID'");
		return $query;
	}
	
	// insert a product into a customer's cart
	function insert_cart($customerid, $productID, $productquantity) {
		$query = $this->db->query("INSERT INTO cart (customerID, productID, productquantity) VALUES ('$customerid', '$productID', '$productquantity')");
		return $query;
	}
	
	/*--- specialsale display in homepage functionality --_*/
	// get specialsale for getspecialsale_view display
	function get_specialsale($td, $tm, $ty) {
		$query=$this->db->query("SELECT specialsale.specialID, specialsale.productID, product.productname, product.price, specialsale.discount, specialsale.startday, specialsale.startmon, specialsale.startyear, specialsale.endday, specialsale.endmon, specialsale.endyear FROM product, specialsale WHERE product.productID=specialsale.productID  AND (specialsale.startyear<'".$ty."' OR (specialsale.startyear='".$ty."' AND specialsale.startmon<'".$tm."') OR (specialsale.startyear='".$ty."' AND specialsale.startmon= '".$tm."' AND specialsale.startday<= '".$td."')) AND (specialsale.endyear>'".$ty."' OR (specialsale.endyear='".$ty."' AND specialsale.endmon>'".$tm."') OR (specialsale.endyear='".$ty."' AND specialsale.endmon='".$tm."' AND specialsale.endday>= '".$td."'))");
	    return $query->result_array();
	}
	
	// get categories for select droplist in the head_view 
	function get_category() {
		$query=$this->db->query('SELECT productcategoryid, productcategoryname from  productcategory');
        return $query->result_array();
	}
	
	/*--- search functionality --_*/
	// check if there exists products that matches the input and category when you click search
	function search_all($skey, $categID) {
		$sql = "SELECT productID FROM product WHERE productname LIKE '%$skey%'";
		if ($categID!= 'all'){
	    	$sql = $sql." AND productcategoryid = '$categID'";
		}
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
	
	// get specialsales according to category and key word
	function search_specialsale($skey, $categID) {
		$sql="SELECT product.productID, product.productname, product.price, product.productcategoryid, specialsale.specialID, specialsale.productID, specialsale.discount, specialsale.startday, specialsale.startmon, specialsale.startyear, specialsale.endday, specialsale.endmon, specialsale.endyear, productcategory.productcategoryid, productcategory.productcategoryname FROM product, specialsale, productcategory WHERE product.productID=specialsale.productID AND product.productcategoryid=productcategory.productcategoryid";
		if(strlen($skey)){
	     	$sql = $sql." AND product.productname LIKE '%$skey%'";
		}
		
		if (strlen($categID) && $categID!= 'all'){
	    	$sql = $sql." AND product.productcategoryid = '$categID'";
		}
		
		$td=date("j",time());
    	$tm=date("n",time());
    	$ty=date("Y",time());
    
    	$sql=$sql." AND (specialsale.startyear<'".$ty."' OR (specialsale.startyear='".$ty."' AND specialsale.startmon<'".$tm."') OR (specialsale.startyear='".$ty."' AND specialsale.startmon= '".$tm."' AND specialsale.startday<= '".$td."')) AND (specialsale.endyear>'".$ty."' OR (specialsale.endyear='".$ty."' AND specialsale.endmon>'".$tm."') OR (specialsale.endyear='".$ty."' AND specialsale.endmon='".$tm."' AND specialsale.endday>= '".$td."'))";
    	
    	$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	// get nonspecialsale according to category and key word
	function search_nonspecialsale($skey, $categID) {
		$td=date("j",time());
    	$tm=date("n",time());
    	$ty=date("Y",time());
    	
		$sql = "SELECT p.productID, p.productname, p.price, pc.productcategoryname FROM product p, productcategory pc WHERE p.productID NOT IN (SELECT p.productID FROM product p, specialsale ss WHERE p.productID = ss.productID AND (ss.startyear<'".$ty."' OR (ss.startyear='".$ty."' AND ss.startmon<'".$tm."') OR (ss.startyear='".$ty."' AND ss.startmon= '".$tm."' AND ss.startday<= '".$td."')) AND (ss.endyear>'".$ty."' OR (ss.endyear='".$ty."' AND ss.endmon>'".$tm."') OR (ss.endyear='".$ty."' AND ss.endmon='".$tm."' AND ss.endday>= '".$td."')) AND p.productname LIKE '%$skey%') AND p.productcategoryid = pc.productcategoryid AND p.productname LIKE '%$skey%'";	
		if (strlen($categID) && $categID!= 'all'){
	    	$sql = $sql." AND p.productcategoryid = '$categID'";
		}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	/*--- product details functionality ---*/
	
	// get product info via its productID
	function get_product($productID) {
		$sql="SELECT p.productID, p.productname, p.productcategoryid, pc.productcategoryid, pc.productcategoryname, p.price, p.description FROM product p, productcategory pc WHERE p.productcategoryid = pc.productcategoryid AND p.productID = '$productID'";  		
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	// get product discount info via its productID
	
	function get_discountinfo($productID) {
		$td=date("j",time());
		$tm=date("n",time());
		$ty=date("Y",time());
		
		$sql="SELECT * FROM specialsale WHERE productID='$productID' AND (startyear<'".$ty."' OR (startyear='".$ty."' AND startmon<'".$tm."') OR (startyear='".$ty."' AND startmon= '".$tm."' AND startday<= '".$td."')) AND (endyear>'".$ty."' OR (endyear='".$ty."' AND endmon>'".$tm."') OR (endyear='".$ty."' AND endmon='".$tm."' AND endday>= '".$td."'))";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	/*--- recommendation functionality ---*/
	
	function get_recommend($productID) {
		$sql = "SELECT first, second FROM relation WHERE productID='$productID'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	/*--- profile functionality ---*/
	
	function get_profile($customerid) {
		$sql = "SELECT * FROM customers WHERE customerID='$customerid'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function insert_profile($newusername, $newpassword, $newfirstname, $newlastname, $birth, $cardnum, $cardtype, $expire, $shipadd, $billadd, $email, $phone){
        $sql = "INSERT INTO customers (username, password, firstName, lastName, birth, email, phone, cardNumber, cardType, expireDate, billAdd, shipAdd) VALUES ('$newusername', password('$newpassword'), '$newfirstname', '$newlastname','$birth', '$email', '$phone', '$cardnum', '$cardtype', '$expire', '$billadd', '$shipadd')";
        $query = $this->db->query($sql); 
        return $query;
    }
    
    function update_profile($customerid, $newusername, $newpassword, $newfirstname, $newlastname, $birth, $cardnum, $cardtype, $expire, $shipadd, $billadd, $email, $phone){
        $sql = "UPDATE customers SET username='$newusername', password=password('$newpassword'), firstname='$newfirstname', lastName='$newlastname', birth='$birth', email='$email', phone='$phone', cardNumber='$cardnum', cardType='$cardtype', expireDate='$expire', billAdd='$billadd', shipAdd='$shipadd' WHERE customerID='$customerid'";
        $query = $this->db->query($sql); 
        return $query; 
    }
    
    
    /*--- addCart functionality ---*/
    
    function cart_productquantity($customerid, $productID){
        $query=$this->db->query("SELECT productquantity FROM cart WHERE customerID='$customerid' AND productID='$productID'");
        return $query->row_array();     
        //"SELECT productquantity FROM cart WHERE customerID=$customerid AND productID=$productID"
    }

    function updatecart_pqty($customerid, $productID, $qty){
    	$sql = "UPDATE cart SET productquantity='$qty' WHERE customerID='$customerid' AND productID='$productID'"; 
    	$query=$this->db->query($sql);
    	/*
       $data = array(
            'productquantity' => $qty
        );
        $this->db->where('customerID', $customerid)
                 ->where('productID', $productID);
        $this->db->update('cart', $data);
        */
        
        //$this->db->query("UPDATE cart SET productquantity='$qty' WHERE customerID='$customerid' AND productID='$productID'");
            
        //"UPDATE cart SET productquantity='$qty' WHERE customerID='$customerid' AND productID='$productID'"; 
    }
    
    function insertcart($customerid, $productID, $qty){
        $data = array(
            'customerID' => $customerid,
            'productID' => $productID,
            'productquantity' => $qty
        );
        $this->db->insert('cart', $data); 
        //$sql_action = "INSERT INTO cart (customerID, productID, productquantity) VALUES ('$customerid', '$productID', '$qty')";
    }
    
    
    /*--- displayCart functionality ---*/
    
    function cartdelete($customerid, $delete){
    	$sql = "DELETE FROM cart WHERE productID = '$delete' AND customerID='$customerid'";
    	$query = $this->db->query($sql);
    	return $query;
        //$sql_del = "DELETE FROM cart WHERE productID = '$delete' AND customerID='$customerid'";
    } 
    
    function cart_cusid($customerid){
        $query=$this->db->query("SELECT productID, productquantity FROM cart WHERE customerID='$customerid'");
        return $query->result_array();
        //$sql= "SELECT * FROM cart WHERE customerID=$customerid";
    }
    
     function product_pid($productID){
        $query=$this->db->query("SELECT * FROM product WHERE productID= '$productID' ");
        return $query->row_array();
        //$sql_cp="SELECT * FROM product WHERE productID=$productID";
    }  
    
    function ss_discount($productID){
        $query=$this->db->query("SELECT discount FROM specialsale WHERE productID = '$productID'");
        return $query->row_array();
        //$sql2 = "SELECT discount FROM specialsale WHERE productID = '$productID'";  
    } 
	
	function cart_info($customerid){
        $query=$this->db->query("SELECT cart.productID, cart.productquantity, product.price FROM cart, product WHERE customerID='$customerid' and cart.productID=product.productID ");
        return $query->result_array();
        //$sql= "SELECT * FROM cart WHERE customerID=$customerid";
    }
    
    
    /*--- order functionality ---*/
    
    // get orderlist of a customer
    
    function get_orderlist($customerid){
    	$sql = "SELECT orderID, customerID, orderdate, totalpay from orderlist WHERE customerID = '$customerid' ORDER BY orderID DESC";
    	$query=$this->db->query($sql);
    	return $query->result_array();
    }
	
	// get general info of an order
	function get_order($customerid, $orderid) {
		$sql = "SELECT orderdate, totalpay FROM orderlist WHERE orderID = '$orderid' AND customerID = '$customerid'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	// get an order detail
	function get_orderinfo($orderid) {
		$sql = "SELECT p.productID, p.productname, o.productquantity, o.price FROM product p, orders o WHERE p.productID = o.productID AND o.orderID = '$orderid' ";		
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	/*--- checkout functionality ---*/
	
	function product_cart($customerid){
        $query=$this->db->query("SELECT p.productID, p.productname, p.price, c.productquantity FROM product p, cart c WHERE p.productID = c.productID AND c.customerID = '$customerid'");
        return $query->result_array();
        //"SELECT p.productID, p.productname, p.price, c.productquantity FROM product p, cart c WHERE p.productID = c.productID AND c.customerID = '$customerid'";
    }
    
    function cus_id($customerid){
        $query=$this->db->query("SELECT * from customers WHERE customerID='$customerid'");
        return $query->row_array();
        //"SELECT * from customers WHERE customerID=$customerid";
    }
    
    function get_specialsale_bypid($pc_pid){
                
        $td=date("j",time());
        $tm=date("n",time());
        $ty=date("Y",time());
    
        $sql = "SELECT discount FROM specialsale WHERE productID='$pc_pid' AND (startyear<'".$ty."' OR (startyear='".$ty."' AND startmon<'".$tm."') OR (startyear='".$ty."' AND startmon= '".$tm."' AND startday<= '".$td."')) AND (endyear>'".$ty."' OR (endyear='".$ty."' AND endmon>'".$tm."') OR (endyear='".$ty."' AND endmon='".$tm."' AND endday>= '".$td."'))";	  
        $query=$this->db->query("$sql");
        return $query->row_array();
    }
    
    /*--- order confirm functionality ---*/
    // insert a checkout order into orderlist
	function insert_orderlist($customerid, $today, $totalPrice) {
		$sql = "INSERT INTO orderlist (customerID, orderdate, totalpay) VALUES ('$customerid', '$today', '$totalPrice')";
		$query=$this->db->query($sql);
		return $query;
	}
	
	function get_lastid() {
		$sql = "SELECT LAST_INSERT_ID()";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function get_cartinfo($customerid) {
		$sql = "SELECT * from cart WHERE customerID='$customerid'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function get_discount($productid) {
		$sql = "SELECT discount FROM specialsale WHERE productID='$productid'";
        
        $td=date("j",time());
        $tm=date("n",time());
        $ty=date("Y",time());
        
        $sql=$sql." AND (startyear<'".$ty."' OR (startyear='".$ty."' AND startmon<'".$tm."') OR (startyear='".$ty."' AND startmon= '".$tm."' AND startday<= '".$td."')) AND (endyear>'".$ty."' OR (endyear='".$ty."' AND endmon>'".$tm."') OR (endyear='".$ty."' AND endmon='".$tm."' AND endday>= '".$td."'))";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function get_priceinfo($productid) {
		$sql = "SELECT price FROM product WHERE productID ='$productid'";
		$query=$this->db->query($sql);
		return $query->row_array();		
	}
	
	function insert_orders($orderid, $productid, $qty, $Price) {
		$sql = "INSERT INTO orders (orderID, productID, productquantity, price) VALUES($orderid, $productid, $qty, $Price)";
		$query=$this->db->query($sql);
		return $query;
	}
	
	function delete_cartinfo($customerid) {
		$sql= "DELETE FROM cart WHERE customerID='$customerid'";
		$query=$this->db->query($sql);
		return $query;
	}
    
}

?>