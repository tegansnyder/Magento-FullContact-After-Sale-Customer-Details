<?php
class Bulubox_Fullcontact_Model_Observer extends Mage_Core_Model_Abstract
{
    public function purchaseComplete($observer)
    {
    
    	try {
    
	    	$order = $observer->getEvent()->getOrder();
			$customer_id = $order->getCustomerId();
				
			// prevent a duplicate information from being inserted into full contact table
			$exists = Mage::getModel('bulubox_fullcontact/people')->getCollection()
			    ->addFieldToSelect('customer_id')
			    ->addFieldToFilter('customer_id',$customer_id)->getFirstItem();
			
			
			if (!$exists->getOrderId()) {
				
		    	$customer = Mage::getModel('customer/customer')->load($customer_id);
		    	$customer_email = $customer_data['email'];

	    		include_once('/sites/magento/fullcontact/src/FullContact.php');
	    		
	    		$fullcontact = new FullContactAPI('4bd22ccd0ed6ffe2');
	    		$result = $fullcontact->doLookup($customer_email);
	    		
	    		$status = $result['status'];
	    		
	    		if ($status != '404') {
	    		
	    			$likelihood = $result['likelihood'];
	    			$photos = $result['photos'];
	    			$contactInfo = $result['contactInfo'];
	    			
	    			if (isset($result['demographics'])) {
	    			
	    				$demographics = $result['demographics'];
	    			
	    			} else {
	    			
	    				$demographics = array();
	    				
	    			}
	    			$socialProfiles = $result['socialProfiles'];
	    			
	    			if (isset($contactInfo['websites'])) {
	    			
	    				$websites = $contactInfo['websites'];
	    			
	    			} else {
	    			
	    				$websites = array();
	    			
	    			}
	    			
	    			$html = '<h1>New Customer Information</h1>';
	    			
	    			$html .= '<table width="100%" border="0" cellspacing="3" cellpadding="3">';
	    			$html .= '<tr><td width="18%">Status</td><td width="82%">' . $status . '</td></tr>';
	    			$html .= '<tr><td width="18%">Likelihood</td><td width="82%">' . $likelihood . '</td></tr>';
	    			$html .= '</table>';
	    			
	    			$html .= '<hr>';
	    			$html .= '<h3>Photos</h3>';
	    			
	    			if (isset($photos)) {
	    			
	    				$html .= '<table width="100%" border="0" cellspacing="3" cellpadding="3">';
	    				
	    				foreach ($photos as $n) {
	    					
	    					$html .= '<tr><td width="18%">Photo</td><td width="82%"><img src="'.$n['url'].'" alt="'.$n['type'].'"></td></tr>';
	    				
	    				}
	    				
	    				$html .= '</table>';
	    				
	    			}
	    			
	    			$html .= '<hr>';
	    			$html .= '<h3>Contact Info</h3>';
	    			
	    			$html .= '<table width="100%" border="0" cellspacing="3" cellpadding="3">';
	    			
	    			foreach ($contactInfo as $key => $value) {
	    			
	    				if ($key == 'websites') {
	    				
	    					foreach ($websites as $website) {
	    					
	    						foreach ($website as $site) {
	    			
	    							$html .= '<tr><td width="18%">Website</td><td width="82%">' . $site . '</td></tr>';
	    						
	    						}
	    						
	    					}
	    					
	    					$html .= '<br>';
	    				
	    				} else {
	    				
	    					$html .= '<tr><td width="18%">'.$key.'</td><td width="82%">' . $value . '</td></tr>';
	    				
	    				}
	    				
	    			}
	    			
	    			$html .= '</table>';
	    			
	    			$html .= '<hr>';
	    			$html .= '<h3>Demographics</h3>';
	    			
	    			$html .= '<table width="100%" border="0" cellspacing="3" cellpadding="3">';
	    			
	    			foreach ($demographics as $key => $value) {
	    			
	    				$html .= '<tr><td width="18%">'.$key.'</td><td width="82%">' . $value . '</td></tr>';
	    				
	    			}
	    			
	    			$html .= '</table>';

	    			$html .= '<hr>';
	    			$html .= '<h3>Social Profiles</h3>';
	    			
	    			$html .= '<table width="100%" border="0" cellspacing="3" cellpadding="3">';
	    			
	    			foreach ($socialProfiles as $profile) {
	    			
	    				foreach ($profile as $key => $value) {
	    				
	    					$html .= '<tr><td width="18%">'.$key.'</td><td width="82%">' . $value . '</td></tr>';
	    				
	    				}
	    				
	    			}
	    			
	    			$html .= '</table>';
	    			
//	    			$mail = Mage::getModel('core/email');
//	    			$mail->setToName('Bulu Box');
//	    			$mail->setToEmail('tegan@bulubox.com');
//	    			$mail->setBody($html);
//	    			$mail->setSubject('New Customer Information');
//	    			$mail->setFromEmail('hello@bulubox.com');
//	    			$mail->setFromName("Bulu Box");
//	    			$mail->setType('html');
//	    			$mail->send();

	    			$sub = Mage::getSingleton('bulubox_fullcontact/people');
	    			$sub->setCustomerId($customer->getId());
	    			$sub->setCustomerName($customer->getFirstname() . ' ' . $customer->getLastname());
	    			$sub->setOrderId($order->getIncrementId());
	    			$sub->setOrderDate(strtotime("now"));
	    			
	    			$sub->setDetails($html);
	    			$sub->save();
	    		
	    		}
	    	
	    	}
	    	
	    } catch(Exception $e){
	    	Mage::log($e,null,'fullcontact-errors.log');
	    }

    }
    
}
?>