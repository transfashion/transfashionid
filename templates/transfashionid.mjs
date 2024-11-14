import _, { map } from './assets/underscore-esm-min.mjs'
import { Promoter } from './assets/dw-promoter.mjs'
import { Searchbox } from './assets/dw-searchbox.mjs'


const SCROLL_NONE = 0;
const SCROLL_UP = 1;
const SCROLL_DOWN = -1;

const head = document.getElementById('head');
const main = document.getElementById('main');
const sidebar = document.getElementById('sidebar');
const searchbar = document.getElementById('searchbar');
const searchresult = document.getElementById('searchresult');
const btn_sidebar_show = document.getElementById('btn_page_sidebar_show');
const btn_sidebar_hide = document.getElementById('btn_page_sidebar_hide');


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

	Promoter({}, (info)=>{ window_resize(); }); // init promoter
	Searchbox(); // init searchbox

	btn_sidebar_show.onclick = () => {
		sidebar_show(true);
 	}
	
	btn_sidebar_hide.onclick = () => {
		sidebar_show(false);
	}
}

function window_resize() {
	if (searchbar.checkVisibility()) {
		searchbar.classList.add('hidden'); // apabila searchbar visible, di hide dulu
	}
	if (searchresult.checkVisibility()) {
		searchresult.classList.add('hidden'); // apabila  searchresult visible, di hide dulu
	}
	var rect = head.getBoundingClientRect();
	head.Height = Math.round(rect.height, 0);

	console.log('head.Height', head.Height)


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