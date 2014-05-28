if (typeof jQuery != 'undefined') {
    jQuery(document).ready(function(){
		jQuery.fn.changeReadOnlyColor = function(){
			return this.each(function(){
				var a = jQuery(this);
				a.css('background-color','#F0F0F0');
				a.css('color','#707070');
			});
		}
		jQuery("input[disabled]").changeReadOnlyColor();
		jQuery("textarea[disabled]").changeReadOnlyColor();
		jQuery("select[disabled]").changeReadOnlyColor();
    });
} 