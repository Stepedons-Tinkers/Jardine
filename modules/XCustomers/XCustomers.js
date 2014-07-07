/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
if (typeof jQuery != 'undefined') {
    jQuery(document).ready(function(){
		jQuery.fn.customerTypeDependency = function(){
			var a = jQuery(this);
			a.unbind().change(function(e){
				if(a.val() == 'Modern Trade'){
					jQuery('#z_cu_chainname').parent().css('display','');
					jQuery('#z_cu_chainname').parent().prev('td').css('display','');
				}
				else{
					jQuery('#z_cu_chainname').parent().css('display','none');
					jQuery('#z_cu_chainname').parent().prev('td').css('display','none');
					jQuery("#z_cu_chainname").val('');
				}
			});
		}
		jQuery("#z_cu_customertype").customerTypeDependency();
    });
} 