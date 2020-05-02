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
	$('#hideStickyDiv').prop("checked", false);
	$('#hideStickyDiv').change(function(){
		if(this.checked)
			$('#nav-tabContent').animate({
				opacity: 1
			}, 250, function() {

			});
			//$('#nav-tabContent').fadeIn('fast');
		else
			$('#nav-tabContent').animate({
				opacity: 0
			}, 250, function() {

			});
			//$('#nav-tabContent').fadeOut('slow');
	});
});