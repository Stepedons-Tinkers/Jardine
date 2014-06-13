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
		jQuery.fn.clearUIType10Dependent = function(){
			var a = jQuery(this);
			a.unbind().change(function(e){
				//clear Customer, Workplan
				jQuery("#z_ac_workplan").val('');
				jQuery("#z_ac_workplan_display").val('');
				jQuery("#z_ac_workplanentry").val('');
				jQuery("#z_ac_workplanentry_display").val('');
				// jQuery("#z_ac_customer").val('');
				// jQuery("#z_ac_customer_display").val('');
			});
		}
		jQuery("#assigned_user_id").clearUIType10Dependent();
    });
} 