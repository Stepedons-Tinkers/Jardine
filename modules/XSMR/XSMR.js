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
		jQuery.fn.autoPopulateSMRFields = function(){
			var a = jQuery(this);
			a.unbind().change(function(e){
				e.preventDefault();
				var assignedto = a.val();
				var module = jQuery("input[name='module']").val();

				var datastring = 'module=NextIXfunctions&action=getUserDetails&assignedto='+assignedto+'&thisModule='+module;
				jQuery.ajax({
					 url:    'index.php',
					 type : 'post',
					 data : datastring,
					 success: function(result) {
								var log = result.split('___THIS_IS_THE_INDICATOR___');
								var myData = JSON.parse(log[1]);
								// console.log(myData);
								jQuery("#z_smr_firstname").val(myData.first_name);
								jQuery("#z_smr_lastname").val(myData.last_name);
								var area = myData.z_area.split(' |##| ');
								jQuery("#z_area").val(area);
								
							  },
					 async:   false
				}); 		

			});
		}
		jQuery("#assigned_user_id").autoPopulateSMRFields();
    });
} 