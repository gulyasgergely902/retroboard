$(function(){
	if(getCookieByName("index_add-popover_dismissed") == "false"){
		$('#addboard').popover('show');
		$('#addboard').on('shown.bs.popover', function(){
			setTimeout(function(){
				$('#addboard').popover('hide');
			}, 2000);
		});
		$('#addboard').on('click', function(){
			//$('#addboard').popover('dispose');
			var exp_date = new Date();
			var cookie_string = '';
		
			exp_date.setFullYear(exp_date.getFullYear() + 1);
			cookie_string = "index_add-popover_dismissed = true; path=/; expires=" + exp_date.toUTCString();
			document.cookie = cookie_string;
		});
	}
	if(getCookieByName("display_addsingle-popover_dismissed") == "false"){
		$("#addsingle").popover('show');
		$('#addsingle').on('shown.bs.popover', function(){
			setTimeout(function(){
				$('#addsingle').popover('hide');
			}, 2000);
		});
		$("#addsingle").on('click', function(){
			//$('#addsingle').popover('dispose');
			var exp_date = new Date();
			var cookie_string = '';

			exp_date.setFullYear(exp_date.getFullYear() + 1);
			cookie_string = "display_addsingle-popover_dismissed = true; path=/; expires" + exp_date.toUTCString();
			document.cookie = cookie_string;
		});
	}
	if(getCookieByName("display_deleteall-popover_dismissed") == "false"){
		$("#deleteall").popover('show');
		$('#deleteall').on('shown.bs.popover', function(){
			setTimeout(function(){
				$('#deleteall').popover('hide');
			}, 2000);
		});
		$("#deleteall").on('click', function(){
			//$('#deleteall').popover('dispose');
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