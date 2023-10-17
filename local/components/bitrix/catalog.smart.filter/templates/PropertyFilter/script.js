const DependencyFields = function() {
	this.settings = {
		'mapLayoutBigInputSelector':'body form #collapseMAP_LAYOUT_BIG input',
		'mapLayoutBig':'body form #MAP_LAYOUT_BIG',
		'mapLayoutDropdown':'body form .card-header#MAP_LAYOUT',
		'mapLayoutDropdownBody':'body form #collapseMAP_LAYOUT',
		'mapLayoutBtnActivate':'body form .card-header#MAP_LAYOUT button',
	}

	this.$mapLayoutBigInputs =  document.querySelectorAll(this.settings.mapLayoutBigInputSelector);
	this.$mapLayoutBig =  document.querySelector(this.settings.mapLayoutBig);
	this.$mapLayout = document.querySelector(this.settings.mapLayoutDropdown);
	this.$mapLayoutBody = document.querySelector(this.settings.mapLayoutDropdownBody);
	this.$mapLayoutBtn = document.querySelector(this.settings.mapLayoutBtnActivate);

	this.init();
}

DependencyFields.prototype.init = function ()
{
	this.dependencyFiledClickEvent();
	this.mainFiledDropdownClickEvent();
	this.mainFiledCheckboxClickEvent();
	if (this.checkboxIsSelected()) {
		if (this.$mapLayout.classList.contains('disabled')) this.$mapLayout.classList.remove('disabled');
		this.$mapLayoutBody.setAttribute('id','collapseMAP_LAYOUT');
	} else {
		this.$mapLayoutBody.setAttribute('id','');
	}
}

DependencyFields.prototype.mainFiledDropdownClickEvent = function () {
	if (this.$mapLayoutBig) {
		this.$mapLayoutBig.onclick = () => {
			if (this.checkboxIsSelected()) {
				this.showDependencyFiledBody()
			} else {
				this.hideDependencyFiledBody()
			}
		}
	}
}

DependencyFields.prototype.mainFiledCheckboxClickEvent = function () {
	if (this.$mapLayoutBigInputs) {
		this.$mapLayoutBigInputs.forEach((input) => {
			input.onclick = () => {
				if (this.checkboxIsSelected()) {
					this.showDependencyFiledBody()
				} else {
					this.hideDependencyFiledBody()
				}
			}
		});
	}
}

DependencyFields.prototype.dependencyFiledClickEvent = function () {
	if (this.$mapLayout) {
		this.$mapLayout.onclick = () => {
			if (this.$mapLayout.classList.contains('disabled')) {
				let mapLayoutBigBtn = this.$mapLayoutBig.querySelector('button');
				if (mapLayoutBigBtn && mapLayoutBigBtn.getAttribute('aria-expanded') === "false") mapLayoutBigBtn.click();
			}
		}
	}
}

DependencyFields.prototype.showDependencyFiledBody = function () {
	if (this.$mapLayout.classList.contains('disabled')) this.$mapLayout.classList.remove('disabled');
	this.$mapLayoutBody.setAttribute('id', 'collapseMAP_LAYOUT');
	if (!this.$mapLayoutBody.classList.contains('show')) this.$mapLayoutBtn.click();
}

DependencyFields.prototype.hideDependencyFiledBody = function () {
	this.$mapLayoutBody.setAttribute('id', 'collapseMAP_LAYOUT');
	if (this.$mapLayoutBody.classList.contains('show')) this.$mapLayoutBtn.click();
	this.$mapLayoutBody.setAttribute('id','');
	if (!this.$mapLayout.classList.contains('disabled')) this.$mapLayout.classList.add('disabled');
}

DependencyFields.prototype.checkboxIsSelected = function () {
	let checking = false;
	if (this.$mapLayoutBigInputs) {
		this.$mapLayoutBigInputs.forEach((input) => {
			if (input.checked === true) checking = true;
		});
	}
	return checking;
}

addEventListener('DOMContentLoaded', () => {
	new DependencyFields();

	function changeTypeRent(element) {

		if ($('#buyCheck1').is(':checked') == false) {
			let elem = document.getElementById("arrFilter_178_1500340406");
			elem.checked = false;

		} else {
			let elem = document.getElementById("arrFilter_178_1500340406");
			elem.click();
			elem.checked = true;

		}
		if ($('#renCheck1').is(':checked') == false) {
			let elem = document.getElementById("arrFilter_178_1577100463");
			elem.checked = false;

		} else {
			let elem = document.getElementById("arrFilter_178_1577100463");
			elem.click();
			elem.checked = true;

		}
	}
	
	let elem1 = document.getElementById("arrFilter_178_1500340406");
	let elem2 = document.getElementById("arrFilter_178_1577100463");
	if (elem1.checked == true) {
		let elem = document.getElementById("buyCheck1");
		elem.checked = true
	}
	if (elem2.checked == true) {
		let elem = document.getElementById("renCheck1");
		elem.checked = true
	}

});