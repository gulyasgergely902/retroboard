$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var boardName = button.data('boardname');
  var bid = button.data('bid');
  var modal = $(this);
  modal.find('.modal-body').text('This will delete ' + boardName + ' board! Are you sure?');
  modal.find('.hiddenBidBoxRemove').val(bid);
});

$('#passwordModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var bid = button.data('bid');
  var modal = $(this);
  modal.find('.hiddenBidBoxUnlock').val(bid);
});

$(document).ready(function(){
	//$('#hideStickyDiv').prop("checked", false);
    if($('#hideStickyDiv').is(":checked")) {
        $('#nav-tabContent').transition({
            "opacity": "1",
            "filter": "blur(0)",
            "-webkit-filter": "blur(0)"
        }, 1, 'linear');
    } else {
        $('#nav-tabContent').transition({
            "opacity": "0",
            "filter": "blur(10px)",
            "-webkit-filter": "blur(10px)"
        }, 1, 'in-out');
    }
	$('#hideStickyDiv').change(function(){
		if(this.checked)
			$('#nav-tabContent').transition({
				"opacity": "1",
				"filter": "blur(0)",
				"-webkit-filter": "blur(0)"
			}, 250, 'linear');
		else
			$('#nav-tabContent').transition({
				"opacity": "0",
				"filter": "blur(10px)",
				"-webkit-filter": "blur(10px)"
			}, 250, 'in-out');
	});
});

document.getElementById('sticky-content').onkeyup = function () {
    document.getElementById('sticky-content-charcount').innerHTML = "Characters left: " + (500 - this.value.length);
};