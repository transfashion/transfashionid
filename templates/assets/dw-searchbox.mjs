import _, { assign, map, object } from './underscore-esm-min.mjs'

const input_desktop_name = 'input_desktop_search';
const input_mobile_name = 'input_mobile_search';


const input_desktop = document.getElementById(input_desktop_name);
const input_mobile  = document.getElementById(input_mobile_name);
const searchInputs = document.querySelectorAll('.dw-searchbox input');
const searchButtons = document.querySelectorAll('.dw-searchbox button');


let Options = {}; 

export const Searchbox = {
	Init: async (opt) => {
		searchbox_init(opt);	
	} 
}


async function searchbox_init(opt) {
	assign(Options, opt);

	// setup input
	searchInputs.forEach(input => {
		// baca event keyup
		input.addEventListener('keyup', _.throttle(searchbox_keyup, 500), { passive: true});	
		input.addEventListener('blur', (evt) => { searcbox_input_blur(evt) });
	});

	// setup button
	searchButtons.forEach(btn => {
		btn.onclick = () => {
			searchbox_button_click(btn);
		}

		// setup iconbutton, jika functional=close, tombol selalu icon close
		if (btn.getAttribute('functional')=='close') {
			btn.classList.add('dw_searchbox_button_close')
		}
	});
}


function searchbox_keyup(e) {
	// sync input
	if (e.target.id === input_desktop_name) {
		input_mobile.value = input_desktop.value;
	} else {
		input_desktop.value = input_mobile.value;
	}
	var searchtext = input_desktop.value;

	// jadi tombol clear
	searchButtons.forEach(btn => {
		if (btn.getAttribute('functional')!='close') {
			if (searchtext.length > 0) {
				btn.classList.add('dw_searchbox_button_close');
			} else {
				btn.classList.remove('dw_searchbox_button_close');
			}
		}
	});

	// jalankan event onSearch
	if (typeof Options.onSearch === 'function') {
		Options.onSearch(searchtext);
	}
}

function searchbox_button_click(btn) {
	// funsi click button bukan buat search, tapi untuk clear text 
	// dan cancel search
	if (btn.classList.contains('dw_searchbox_button_close')) {
		searchInputs.forEach(input => {
			input.value = '';  // kosongkan input
		});

		if (typeof Options.onClose === 'function') {
			Options.onClose();
		}
	}

	// kembalikan icon button
	searchButtons.forEach(btn => {
		if (btn.getAttribute('functional')!='close') {
			btn.classList.remove('dw_searchbox_button_close');
		}
	});
	
}

function searcbox_input_blur(evt) {
	// cek text
	var searchtext = evt.target.value;
	if (searchtext.length==0) {
		var closeonblur = evt.target.getAttribute('closeonblur');
		if (closeonblur=='true') {
			if (typeof Options.onClose === 'function') {
				Options.onClose();
			}
		}
	}
}