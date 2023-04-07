var abc = 0;      // Declaring and defining global increment variable.
jQuery(document).ready(function($) {

$('body').on('change', '.sync_file', function() {
if (this.files && this.files[0]) {
abc += 1; // Incrementing global variable by 1.
var z = abc - 1;
var x = $(this).parent().find('#previewimg' + z).remove();
$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$(this).hide();
$("#abcd" + abc).append($("<a/>", {
href: '#',
text: 'close'
}).click(function() {
$(this).parent().parent().find('input').css('display', 'block');
$(this).parent().parent().find('input').val(''); 
$(this).parent().remove();
}));
}
});
// To Preview Image
function imageIsLoaded(e) {
$('#previewimg' + abc).attr('src', e.target.result);
};
});