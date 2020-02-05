$(function(){
	if(getCookieByName("index_add-popover_dismissed") == "false"){
		$('#addboard').popover('show');
		$('#addboard').on('click', function(){
			$('#addboard').popover('dispose');
			var exp_date = new Date();
			var cookie_string = '';
		
			exp_date.setFullYear(exp_date.getFullYear() + 1);
			cookie_string = "index_add-popover_dismissed = true; path=/; expires=" + exp_date.toUTCString();
			document.cookie = cookie_string;
		});
	}
	if(getCookieByName("display_addsingle-popover_dismissed") == "false"){
		$("#addsingle").popover('show');
		$("#addsingle").on('click', function(){
			$('#addsingle').popover('dispose');
			var exp_date = new Date();
			var cookie_string = '';

			exp_date.setFullYear(exp_date.getFullYear() + 1);
			cookie_string = "display_addsingle-popover_dismissed = true; path=/; expires" + exp_date.toUTCString();
			document.cookie = cookie_string;
		});
	}
	if(getCookieByName("display_deleteall-popover_dismissed") == "false"){
		$("#deleteall").popover('show');
		$("#deleteall").on('click', function(){
			$('#deleteall').popover('dispose');
			var exp_date = new Date();
			var cookie_string = '';

			exp_date.setFullYear(exp_date.getFullYear() + 1);
			cookie_string = "display_deleteall-popover_dismissed = true; path=/; expires" + exp_date.toUTCString();
			document.cookie = cookie_string;
		});
	}
});

function getCookieByName(name) {
	var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
	if (match) {
		return match[2];
	} else {
		return "false";
	}
}

$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var boardName = button.data('boardname');
  var bid = button.data('bid');
  var modal = $(this);
  modal.find('.modal-body').text('This will delete ' + boardName + ' board! Are you sure?');
  modal.find('.hiddenBidBoxRemove').val(bid);
});

$('#addStickyModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var boardName = button.data('boardname');
  var bid = button.data('bid');
  var modal = $(this);
  modal.find('.hiddenBidBoxAddSticky').val(bid);
});

