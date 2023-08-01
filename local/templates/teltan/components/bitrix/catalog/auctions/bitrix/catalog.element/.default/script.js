(function(window){
	'use strict';

	if (window.JCCatalogElement)
		return;

	window.JCCatalogElement = function(arParams)
	{
		this.productType = 0;

		this.config = {
			useCatalog: true,
		};

		this.obProduct = null;


		this.params = {};
	};

	window.JCCatalogElement.prototype = {
		init: function()
		{
			var i = 0,
				j = 0,
				treeItems = null;

			this.obProduct = BX(this.visual.ID);
			if (!this.obProduct)
			{
				this.errorCode = -1;
			}

			if (this.errorCode === 0)
			{
			}
		},
	}
	
	$('.invite_user').click(function () {
		let email = prompt('user email');
		let auctionId = $(this).attr('id')
		$.ajax({
			url: '/local/templates/p2a/components/bitrix/catalog/auctions/bitrix/catalog.element/.default/event.php',
			method: 'post',
			dataType: 'html',
			data: {email: email , TASK: 'inviteUser', auctionId: auctionId},
			success: function(){
				alert('invite send')
			}
		});
	})
})(window);