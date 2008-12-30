Event.observe(window, 'load', function () {
	if (!$('module')) return;

	empty_select_box();
	add_dummy_element();

	Event.observe($('module'), 'change', function () {
		new Ajax.Request('/?admin/json_public_items/' + $('module').value, {
			method: 'get',
			onSuccess : function (transport) {
				var items = transport.responseText.evalJSON();
				empty_select_box();
				fill_select_box(items);
			},
			onFailure : function () {
				empty_select_box();
				add_dummy_element();
			}
		});
	});

	Event.observe($('item'), 'change', function () {
		$$('#item option').each(function (option) {
			if (option.selected) set_title_field(option.innerHTML);
		});
	});

});

function empty_select_box () {
	var select = $('item');
	var children = select.childElements();
	for (var i = 0; i < children.length; i++) {
		children[i].remove();
	}
}

function add_dummy_element () {
	var select = $('item');
	select.writeAttribute('disabled', 'disabled');

	var option = new Element('option', {value : -1});
	option.innerHTML = '&ndash; Geen items gevonden &ndash;';
	select.insert(option, 'bottom');
}

function set_title_field (value) {
	var title = $('title');
	title.value = value;
}

function fill_select_box (items) {
	var select = $('item');
	
	if (items.length > 0) {
		select.writeAttribute('disabled', null);
	} else {
		add_dummy_element();
		return;
	}
	
	for (var i = 0; i < items.length; i++) {
		if (i == 0) set_title_field(items[i].title);
		var option = new Element('option', {value : items[i].method+'/'+items[i].param });
		option.innerHTML = items[i].title;
		select.insert(option, 'bottom');
	}
}