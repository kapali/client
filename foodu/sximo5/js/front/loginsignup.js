$('.username').blur(function(){var uname = $(this).val();if(uname.length<3){$('.create_user').prop('disabled','true');$('#uname').addClass('l_err_uname').html('Min 3 characters needed ').css('color','red');}else{$.ajax({type : 'POST',url:base_url+"/user/checkuname",data : {'uname':uname},success: function (data) {if(data == 1){$('.create_user').prop('disabled','true');$('#uname').addClass('reg_err').html('Username already exists').css('color','red');}else{$('.create_user').prop('disabled','');$('#uname').removeClass('reg_err').html('Username ').css('color','#999');}} });}});$('.firstname').blur(function(){var fname = $(this).val();if(fname.length<3){$('.create_user').prop('disabled','true');$('#fname').addClass('reg_err').html('Min 3 characters needed ').css('color','red');}else{$('.create_user').prop('disabled','');$('#fname').removeClass('reg_err').html('First Name').css('color','#999');}});$('.lastname').blur(function(){var lname = $(this).val();if(lname.length<3){$('.create_user').prop('disabled','true');$('#lname').addClass('reg_err').html('Min 3 characters needed ').css('color','red');}else{ $('.create_user').prop('disabled',''); $('#lname').removeClass('reg_err').html('Last Name ').css('color','#999');}});$('.emailaddr').blur(function(){var email = $.trim($(this).val());var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;if(!pattern.test(email)){$('.create_user').prop('disabled','true');$('#email').addClass('reg_err').html('Invalid Email').css('color','red');}else{$.ajax({type : 'POST',url:base_url+"/user/checkemail",data : {'email':email},success: function (data) {if(data == 1){$('.create_user').prop('disabled','true');$('#email').addClass('reg_err').html('Email address already exists').css('color','red');}else{$('.create_user').prop('disabled','');$('#email').removeClass('reg_err').html('Email ').css('color','#999');}} });  }});$('.phone').blur(function(){var phone = $(this).val();if(phone.length<5){$('.create_user').prop('disabled','true');$('#phone').addClass('reg_err').html('Invalid Phone Number').css('color','red');}else{$.ajax({type : 'POST',url:base_url+"/user/checkphone",data : {'phone':phone},success: function (data) {if(data == 1){$('.create_user').prop('disabled','true');$('#phone').addClass('reg_err').html('Phone number already exists').css('color','red');}else{$('.create_user').prop('disabled','');$('#phone').removeClass('reg_err').html('Phone Number ').css('color','#999');}} });    }});$('.password').blur(function(){var password = $(this).val();if(password.length<6){$('.create_user').prop('disabled','true');$('#passwordd').addClass('reg_err').html('Min 6 characters needed ').css('color','red');}else{$('.create_user').prop('disabled','');$('#passwordd').removeClass('reg_err').html('Password').css('color','#999');}});$('.confirmpassword').blur(function(){var password = $('.password').val();var cpassword = $(this).val();if(cpassword.length<6){$('.create_user').prop('disabled','true');$('#confirmpassword').addClass('reg_err').html('Min 6 characters needed ').css('color','red');}else{if(cpassword != password){$('.create_user').prop('disabled','true');$('#confirmpassword').addClass('reg_err').html('Password Mismatch').css('color','red');}else{$('.create_user').prop('disabled','');$('#confirmpassword').removeClass('reg_err').html('Confirm Password').css('color','#999');}}});$('#group_id').on('change',function(){$('#group_id').removeClass('reg_err').css('color','#999');  });$('#phone_code').on('change',function(){$('#phone_code').removeClass('reg_err').css('color','#999');  }); $('.create_user').click(function(){var uname = $('.username').val();var fname = $('.firstname').val();var lname = $('.lastname').val();var email = $.trim($('.emailaddr').val());var phone = $('.phone').val();var password = $('.password').val();var cpassword = $('.confirmpassword').val();var group_id = $('.group_id').val();var phone_code = $('.phone_code').val();if(group_id == ''){$('#group_id').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(phone_code == ''){$('#phone_code').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(fname == ''){$('#fname').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(lname == ''){$('#lname').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(uname == ''){$('#uname').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(email == ''){$('#email').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(phone == ''){$('#phone').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(password == ''){$('#passwordd').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if(cpassword == ''){$('#confirmpassword').addClass('reg_err').css('color','red'); $reg = 1; }else{$reg = 0;}if($reg == 0){$.ajax({type : 'POST',url:base_url+"/user/createusers",data : {'uname':uname,'fname':fname,'lname':lname,'email':email,'phone':phone,'phone_code':phone_code,'group_id':group_id,'password':password},success: function (data) {if(data != ''){$('#reg_success').fadeIn('slow');$('.reg_s').html(data);setTimeout(function(){$('.rightsignup').removeClass('rightsignup-active');$('.overlay').prop('display','block');$('.rightsignin').addClass('rightsign-active');},1000);}} });   }});$('.log_email').blur(function(){var email = $.trim($(this).val());var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;if(!pattern.test(email)){$('.login_frm').prop('disabled','true');$('#log_email').addClass('log_err').html('Invalid Email').css('color','red'); }else{ $.ajax({type : 'POST',url:base_url+"user/checkemail",data : {'email':email}, success: function (data) {if(data == 1){$('.login_frm').prop('disabled','');$('#log_email').removeClass('reg_err').html('Email Address').css('color','#999');}else{$('.login_frm').prop('disabled','true');$('#log_email').addClass('reg_err').html('Email address Not exists . Please Register').css('color','red');  }} });  }});$('.log_password').blur(function(){var password = $(this).val();if(password == ''){$('.login_frm').prop('disabled','true');$('#log_password').addClass('reg_err').html('Please Enter Password').css('color','red');}else{$('.login_frm').prop('disabled','');$('#log_password').removeClass('reg_err').html('Password').css('color','#999');}});$('.login_frm').click(function(){var email = $.trim($('.log_email').val());var password = $('.log_password').val();if(email == ''){$('#log_email').addClass('reg_err').css('color','red'); $log = 1; }else{$log = 0;}if(password == ''){$('#log_password').addClass('reg_err').css('color','red'); $log = 1;}else{$log = 0;}if($log == 0){$('#login_form_slide').submit();}else{e.preventDefault();}});