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
								// var area = myData.z_area.split(' |##| ');
								var area = myData.area;
								jQuery("#z_area").find('option').remove().end();
								jQuery("#z_area").append('<option value="- Select -">- Select -</option>');
								jQuery.each(area,function(e,a){
									jQuery("#z_area").append('<option value="'+a+'">'+a+'</option>');
								});
							  },
					 async:   false
				}); 		

			});
		}
		jQuery("#assigned_user_id").autoPopulateSMRFields();
    });
} 