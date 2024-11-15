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

const btn_sidebar_show = document.getElementById('btn_sidebar_show');
const btn_sidebar_hide = document.getElementById('btn_sidebar_hide');
const btn_search_togle = document.getElementById('btn_search_togle');



let prevScrollY = 0;

export async function Init(opt) {
	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'manual';
	}

	head.PrevHeight = 0
	head.PrevMarginTop = 0

	window.scrollTo(0, 0);
	window.addEventListener('resize', _.throttle(window_resize, 500), { passive: true});  // underscore-esm-min.mjs
	window.addEventListener("scroll", _.throttle(window_scroll, 100), { passive: true});  // underscore-esm-min.mjs	

	Promoter.Init({}, (info)=>{ window_resize(); }); // init promoter
	
	// init searchbox
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

async function searchbox_close() {
	searchdialog.classList.add('hidden');
	mainmask.classList.add('hidden');
}


async function searchbox_search(searchtext) {
	if (!searchdialog.checkVisibility()) {
		searchdialog.classList.remove('hidden');
		mainmask.classList.remove('hidden');
	}

	// do search
	searchtext = searchtext.toLowerCase();
	if (searchtext=="shoes" || searchtext=="bag" || searchtext=="accessories" || searchtext=="bags") {
		// ketemu
	
	} else {	
		// tidak ketemu
		
	}



}


