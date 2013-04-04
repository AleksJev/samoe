 $(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
    $(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
 jQuery(document).ready(function(){
	$('.accordion .head').click(function() {
		$(this).next().toggle();
		return false;
	}).next().hide();
});
jQuery(document).ready(function(){
	$('.accordion .head').click(function() {
		$(this).next().toggle('slow');
		return false;
	}).next().hide();
});