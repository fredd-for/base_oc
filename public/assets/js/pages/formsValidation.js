/*
 *  Document   : formsValidation.js
 *  Author     : pixelcave
 */
var FormsValidation=function(){
	return{init:function(){
		$("#form-validation").validate({
			errorClass:"help-block animation-slideDown",errorElement:"div",errorPlacement:function(e,a){a.parents(".form-group > div").append(e)},highlight:function(e){$(e).closest(".form-group").removeClass("has-success has-error").addClass("has-error"),$(e).closest(".help-block").remove()},success:function(e){e.closest(".form-group").removeClass("has-success has-error"),e.closest(".help-block").remove()},rules:{val_username:{required:!0,minlength:3},val_email:{required:!0,email:!0},val_password:{required:!0,minlength:5},val_confirm_password:{required:!0,equalTo:"#val_password"},val_bio:{required:!0,minlength:5},val_skill:{required:!0},val_website:{required:!0,url:!0},val_credit_card:{required:!0,creditcard:!0},val_digits:{required:!0,digits:!0},val_number:{required:!0,number:!0},val_range:{required:!0,range:[1,1e3]},val_terms:{required:!0}},messages:{val_username:{required:"Please enter a username",minlength:"Your username must consist of at least 3 characters"},val_email:"Please enter a valid email address",val_password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long"},val_confirm_password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long",equalTo:"Please enter the same password as above"},val_bio:"Don't be shy, share something with us :-)",val_skill:"Please select a skill!",val_website:"Please enter your website!",val_credit_card:"Please enter a valid credit card! Try 446-667-651!",val_digits:"Please enter only digits!",val_number:"Please enter a number!",val_range:"Please enter a number between 1 and 1000!",val_terms:"You must agree to the service terms!"}
		}),
		$("#fecha_contrato").mask("99-99-9999"),
		$("#hora_fin").mask("99:99"),
		$("#hora_inicio").mask("99:99"),
		$("#contrato").mask("999/9999"),
		$("#masked_date").mask("99/99/9999"),
		$("#masked_date2").mask("99-99-9999"),
		$("#masked_phone").mask("(999) 999-9999"),
		$("#masked_phone_ext").mask("(999) 999-9999? x99999"),
		$("#masked_taxid").mask("99-9999999"),
		$("#masked_ssn").mask("999-99-9999"),
		$("#masked_pkey").mask("a*-999-a999")
		}}
	}();