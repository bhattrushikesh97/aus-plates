(function ($) {
    "use strict";
    /*verifying Purchase code...*/
    $('#verify_it').on('click', function ()
    {
       
        var purchase_code = document.getElementById('adforest_code').value;
        if (purchase_code != "")
        {
            $.post(ajaxurl, {action: 'verify_code', code: purchase_code}).done(function (response)
            {
                $('#adforest_code').val('');
                if ($.trim(response) == 'Looks good, now you can install required plugins.') { alert(response); location.reload(); } else { alert(response); }
            });
        }
    });
    jQuery(document).ready(function ($) {
        jQuery(document).on('click', '.wpb-textinput.cats_cat, .wpb-textinput.cats_d_cat, .wpb-textinput.cats_round_cat, .wpb-textinput.catsm_cat', function ()
        {
            var $this = jQuery(this);
            $this.attr('autocomplete', 'off');
            $this.addClass('sb-input-loading');
            var adforest_ajax_url_admin = jQuery('#sb-admin-ajax').val();
            var sb_data = 'action=adforest_term_autocomplete';
            jQuery.ajax({
                url: adforest_ajax_url_admin,
                type: "POST",
                data: sb_data,
                dataType: "json",
                success: function (data) { $this.removeClass('sb-input-loading'); jQuery('.sb-admin-dropdown').remove(); $this.after(data); },
                error: function (xhr) { alert('Ajax request fail'); }
            });
            return false;

        });


         jQuery(document).on('click', '.wpb-textinput.cats_l_event_cat', function ()
        {
            var $this = jQuery(this);
            $this.attr('autocomplete', 'off');
            $this.addClass('sb-input-loading');
            var adforest_ajax_url_admin = jQuery('#sb-admin-ajax').val();
            var sb_data = 'action=adforest_term_autocomplete';
            jQuery.ajax({
                url: adforest_ajax_url_admin,
                type: "POST",
                data: sb_data,
                dataType: "json",
                success: function (data) { $this.removeClass('sb-input-loading'); jQuery('.sb-admin-dropdown').remove(); $this.after(data); },
                error: function (xhr) { alert('Ajax request fail'); }
            });
            return false;

        });



      if($('.taxonomy-image') .length > 1){
           $('.theme-cat-image').closest('.form-field').remove();
      }




        jQuery(document).on('click', '.sb-select-term', function ()
        {
            var selected_val = jQuery(this).data('sb-term-value');
            jQuery(this).closest("div.edit_form_line").find("input[name='cats_cat'], input[name='cats_d_cat'], input[name='cats_round_cat'], input[name='catsm_cat']").val(selected_val);
            jQuery(this).closest(".sb-admin-dropdown").remove();
        });
    });
    
    
    $('#sb_deactivate_license').on('click', function ()
    {
       if (confirm("Do you really want to deactivate the license")) {
            $.post(ajaxurl, {action: 'sb_deactivate_license'}).done(function (response)
            { 
              alert(response);
              location.reload();
            });
         } else {
         }         
    });
    
    
    
    $('#send_user_confirmation_email').on('click',function(e){
        
        e.preventDefault();
       
        if (confirm("Are you sure ?")) {
          var    userId     =  $('#send_user_confirmation_email').data('user_id');
            $.post(ajaxurl, {action: 'sb_send_user_account_confirmation_mail' ,user_id: userId}).done(function (response)
            { 
              alert(response);
              
            });
         } else {
         }  
        
        
    });


   $('#sb_deactivate_license').on('click', function ()
    {
       if (confirm("Do you really want to deactivate the license")) {
            $.post(ajaxurl, {action: 'sb_deactivate_license'}).done(function (response)
            { 
              alert(response);
              location.reload();
            });
         } else {
         }         
    });



  $('#set_imported_images').on('click', function ()
    {    
  if (confirm("Are you sure?") == true) {
        $(this).text('importing......');
            $(this).prop('disable' ,true); 
            $.post(ajaxurl, {action: 'sb_set_imported_ad_images'}).done(function (response)
            { 
              alert(response);
              location.reload();
            });

         } else {
              
        }
      });   




  $('#sb_make_ads_activated').on('click', function ()
    {    
  if (confirm("Are you sure?") == true) {

          var this_btn  =   $(this);
         this_btn.text('Activating........');
            this_btn.prop('disable' ,true); 
            $.post(ajaxurl, {action: 'sb_set_all_ads_activated'}).done(function (response)
            { 

                 this_btn.text('Activate ads');

            if(response.success == true){
            
             alert(response.data.message);
             location.reload();

            }
            else {

              alert(response.data.message);  
            }

              
            });
         } else {
              alert(response.data.message);  
        }
      })


 
    
})(jQuery);