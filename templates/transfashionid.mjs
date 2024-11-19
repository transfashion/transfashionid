import _, { map } from './assets/underscore-esm-min.mjs'
import { Promoter } from './assets/dw-promoter.mjs'
import { Searchbox } from './assets/dw-searchbox.mjs'


const SCROLL_NONE = 0;
const SCROLL_UP = 1;
const SCROLL_DOWN = -1;

const head = document.getElementById('head');
const main = document.getElementById('main');
const mainmask = document.getElementById('main-mask');
const sidebar = document.getElementById('sidebar');
const searchdialog = document.getElementById('searchdialog');

const searchdialog_result = document.getElementById('searchdialog-result');
const searchdialog_popular = document.getElementById('searchdialog-popular');

const btn_sidebar_show = document.getElementById('btn_sidebar_show');
const btn_sidebar_hide = document.getElementById('btn_sidebar_hide');
const btn_search_togle = document.getElementById('btn_search_togle');



let prevScrollY = 0;
let prevSearchText = '';

export async function Init(opt) {
	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'manual';
	}

	head.PrevHeight = 0
	head.PrevMarginTop = 0

	window.scrollTo(0, 0);
	window.addEventListener('resize', _.throttle(window_resize, 100), { passive: true});  // underscore-esm-min.mjs
	window.addEventListener("scroll", _.throttle(window_scroll, 100), { passive: true});  // underscore-esm-min.mjs	

	Promoter.Init({
		onVisibilityChanged : () => {
			promoter_visibilitychanged();
		},
		onLoad: (fn_settext) => {
			promoter_load(fn_settext)
		},
		onClose: () => {
			promoter_close()
		}
	});
	
	Searchbox.Init({
		onSearch: (searchtext) => {
			searchbox_search(searchtext);
		},
		onClose: () => {
			searchbox_close();
		}
	}); 

	btn_sidebar_show.onclick = () => {
		sidebar_show(true);
 	}
	
	btn_sidebar_hide.onclick = () => {
		sidebar_show(false);
	}

	btn_search_togle.onclick = () => {
		searchdialog.classList.toggle('hidden');
		if (searchdialog.checkVisibility()) {
			mainmask.classList.remove('hidden');
			var input = document.getElementById('input_mobile_search');
			input.focus(); // fokus ke input_mobile_search
		} else {
			mainmask.classList.add('hidden');
		}
	}
}

function window_resize() {
	var rect = head.getBoundingClientRect();
	head.Height = Math.round(rect.height, 0);
	main.style.marginTop = `${head.Height}px`;

	if (head.PrevHeight != head.Height) {
		head.PrevHeight = head.Height;
		window_scroll();
	}
}

function window_scroll() {
	var Y = window.scrollY;
	var scrolldir = Y > prevScrollY ? SCROLL_UP : SCROLL_DOWN;

	if (Y < head.Height) {
		if (scrolldir === SCROLL_UP) {
			head.classList.remove('header-scrolled')
			head.style.top = `0`;
		} else if (Y < 10){
			setTimeout(() => {
				if (window.scrollY==0) {
					head.classList.remove('header-scrolled')
					head.classList.remove('header-shadowed')
					head.style.top = `0`;
				}
			}, 200);
			head.classList.remove('header-shadowed')
		}
	} else if (scrolldir === SCROLL_UP) {
		head.style.top = `-${head.Height}px`
	} else {
		head.classList.add('header-scrolled')
		head.classList.add('header-shadowed')
		head.style.top = `0px`;
	}
	prevScrollY = Y
}


function sidebar_show(show) {
	var sidebarhead = document.getElementsByClassName('sidebar-header')[0];
	var rect = sidebarhead.getBoundingClientRect();
	var sidebarnav = document.getElementsByClassName('sidebar-nav')[0];

	if (show) {
		sidebar.scrollTo(0, 0);
		sidebar.classList.add('sidebar-showed');
		setTimeout(() => {
			sidebarhead.classList.add('sidebar-header-fixed');
			sidebarnav.style.marginTop = `${rect.height}px`;
		}, 300)
	} else {
		sidebar.classList.remove('sidebar-showed');
		sidebarhead.classList.remove('sidebar-header-fixed');
		sidebarnav.style.marginTop = `0px`;
		sidebar.scrollTop = 0;
	}
}


async function promoter_visibilitychanged() {
	window_resize();
}


async function promoter_close() {
	window_resize();
}

async function promoter_load(fn_settext) {
	var text = 'Dapatkan tambahan discount <b>50%</b> setiap pembelian 2 pairs di <b>GEOX Kota Casablanca</b>,'
	text += ' berlaku <b>hanya hari ini</b> Rabu, 13 November 2024';

	fn_settext(text)
	window_resize();
}



async function searchbox_close() {
	searchdialog.classList.add('hidden');
	mainmask.classList.add('hidden');
	prevSearchText = '';
}


async function searchbox_search(searchtext) {
	searchdialog_popular.classList.remove('hidden');
	if (!searchdialog.checkVisibility()) {
		searchdialog.classList.remove('hidden');
		mainmask.classList.remove('hidden');
	}

	// do search
	searchtext = searchtext.toLowerCase().trim();
	if (searchtext.length>0) {
		searchdialog_result.classList.remove('hidden');
		var insearching = do_search(searchtext)
		if (insearching) {
			searchdialog_result.innerHTML = `Searching <b>${searchtext}</b>...`
		}
	} else {
		searchdialog_result.classList.add('hidden');
	}
}


function do_search(searchtext) {
	if (searchtext==prevSearchText) {
		return false
	}

	var call_search_api = async (callback) => {
		var result = await SEARCH_SIMULATION(searchtext)
		callback(result)
	}

	call_search_api((result)=> {
		if (result==null) {
			searchdialog_result.innerHTML = `Your search <b>${searchtext}</b> did not match any documents`;
		} else {
			searchdialog_result.innerHTML = "ini hasilnya";
			searchdialog_popular.classList.add('hidden');
		}
	})
	

	prevSearchText = searchtext
	return true
}

async function SEARCH_SIMULATION(searchtext) {
	return new Promise((resolve)=>{
		setTimeout(()=>{
			// simulasi search yang membutuhkan waktu sekitar 1 detik
			if (searchtext=="shoes" || searchtext=="bag" || searchtext=="accessories" || searchtext=="bags") {
				// ketemu
				resolve([
					{name: "item 1", price: 10000000},
					{name: "item 2", price: 4000000},
					{name: "item 3", price: 15000}
				]);
			} else {
				// tidak ketemu
				resolve(null)
			}
		}, 1000);
	})
}


