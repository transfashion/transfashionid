import _, { map } from './underscore-esm-min.mjs'
import { Promoter } from './dw-promoter.mjs'


const SCROLL_NONE = 0;
const SCROLL_UP = 1;
const SCROLL_DOWN = -1;

const root = document.documentElement;
const MaxMobileWidth = 1024;

const hMobile = document.querySelector('header[data-display="mobile"]');
const hDesktop = document.querySelector('header[data-display="desktop"]');

const Main = document.querySelector('main');
const Footer = document.querySelector('footer');



let CurrentHeader;
let CurrentHeaderHeight = 0;
let prevScrollY = 0;
let prevMarginTop = 0;

export async function Init(opt) {
	console.log('Layout Init');

	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'manual';
	}
	  

	window.scrollTo(0, 0);
	window.addEventListener('resize', _.throttle(window_resize, 500), { passive: true});  // underscore-esm-min.mjs
	window.addEventListener("scroll", _.throttle(window_scroll, 100), { passive: true});  // underscore-esm-min.mjs	



	var headers = document.querySelectorAll('header')
	Promoter({headers: headers}, (info)=>{
		window_resize();
	});
}

function window_resize() {
	CurrentHeader = hDesktop.checkVisibility() ? hDesktop : hMobile;
	
	var rect = CurrentHeader.getBoundingClientRect();
	CurrentHeader.Height = Math.round(rect.height, 0);

	var marginTop = `${CurrentHeader.Height}px`
	Main.style.marginTop = marginTop;

	if (CurrentHeaderHeight != CurrentHeader.Height) {
		CurrentHeaderHeight = CurrentHeader.Height
		window_scroll()
	}	
}


function window_scroll() {
	var Y = window.scrollY;
	var scrolling = Y > prevScrollY ? SCROLL_UP : SCROLL_DOWN;
	if (Y <= CurrentHeader.Height) {
		CurrentHeader.classList.remove('header_scrolled_down');
		CurrentHeader.style.marginTop = `0px`
	} else {
		console.log('handle header slider scroll');
		if (CurrentHeader.classList.contains('header_scrolled_down')) {
			
		}

	}


	prevScrollY = window.scrollY
}


function window_scroll_() {
	console.log('scroll');
	var Y = window.scrollY;
	var scrolling;
	if (Y > prevScrollY) {
		scrolling = SCROLL_UP
	} else {
		scrolling = SCROLL_DOWN
	}

	var marginTop;
	if (scrolling === SCROLL_UP) {
		CurrentHeader.classList.remove('header_scrolled_down');
		if (Y > CurrentHeader.Height) {
			marginTop = Y - CurrentHeader.Height
		} else {
			marginTop = 0;
		}
		prevMarginTop = marginTop;
	} else if (scrolling === SCROLL_DOWN) {
		if (Y > prevMarginTop + 50) {
			CurrentHeader.classList.remove('header_scrolled_down');
			marginTop = prevMarginTop;
		} else {
			marginTop = 0;
			CurrentHeader.classList.add('header_scrolled_down');
		}
	}
	CurrentHeader.style.marginTop = `${marginTop}px`
	prevScrollY = window.scrollY

}



// function getCurrentViewState(evt) {
// 	var width, heigth, scrolling;
// 	if (evt===undefined) {
// 		scrolling = SCROLL_NONE
// 	} else if (evt.type==='scroll') {
// 		if (window.scrollY > prevScrollY) {
// 			scrolling = SCROLL_UP
// 		} else if (window.scrollY < prevScrollY) {
// 			scrolling = SCROLL_DOWN
// 		} else {
// 			scrolling = SCROLL_NONE
// 		}
// 	} else {
// 		scrolling = SCROLL_NONE
// 	}

// 	width = window.innerWidth
// 	heigth = window.innerHeight
	

	
// 	var header = hDesktop.checkVisibility() ? hDesktop : hMobile;
// 	var rect = header.getBoundingClientRect();
	
// 	var state = {
// 		Width: width,
// 		Height: heigth,
// 		Header: header,
// 		HeaderRect: rect,
// 		HeaderHeight: Math.round(rect.height, 0),
// 		Top: window.scrollY,
// 		Left: window.scrollX,
// 		Scrolling: scrolling
// 	}

// 	return state
// }




// function window_resize(evt) {



	// var ws = getCurrentViewState(evt);
	// console.log(`resize W:${ws.Width}  H:${ws.Height}` );

	// var headerHeight = ws.HeaderRect.height;
	// var marginTop = `${headerHeight}px`
	// Main.style.marginTop = marginTop;

// }/

// function window_scroll(evt) {
// 	var ws = getCurrentViewState(evt);
// 	if (ws.Scrolling==SCROLL_NONE) {
// 		return;
// 	}

// 	// nilai ws.Top akan selalu +, semakin kebawah semakin tinggi

	
// 	var newTop;
// 	var ds =  ws.Top - prevScrollY;
// 	var minMargionTop = -1 * ws.HeaderHeight;
// 	console.log(`scroll ${ws.Scrolling} top:${ws.Top}  left:${ws.Left}  ds:${ds}` );
// 	console.log(`current header height :${ws.HeaderHeight}` );
// 	console.log(`current header top :${ws.HeaderRect.top}` );


	
// 	// else if (ws.Scrolling==SCROLL_UP) {

// 	// } else if (ws.Scrolling==SCROLL_DOWN) {
		
// 	// 	newTop = ws.HeaderRect.top + ds;
// 	// } else {

// 	// }

// 	if (ws.Top <= ws.HeaderHeight) {
// 		newTop =-1*ws.Top
// 	} else {
// 		newTop = Math.round(ws.HeaderHeight, 0)
// 		newTop = -1 * ws.HeaderHeight;
// 	}


// 	console.log(`setup newTop ${newTop}`);
// 	ws.Header.style.top = `${newTop}px`;

// 	// cek top yang telah diimplement
// 	// var rect = ws.Header.getBoundingClientRect();
// 	// console.log(`get currTop ${rect.top}`);

	

// 	// var newTop;
// 	// var HeaderHeight = ws.HeaderRect.height;
// 	// if (ws.Scrolling==SCROLL_UP) {
// 	// 	// Scoll Up
// 	// 	if (ws.HeaderRect.bottom == 0) {
// 	// 		return;
// 	// 	}

// 	// 	if (ws.Top > HeaderHeight) {
// 	// 		newTop = -1 * HeaderHeight;
// 	// 	} else {
// 	// 		newTop = -1 * ws.Top; 
// 	// 	}
// 	// } else {
// 	// 	// Scroll Down
// 	// 	if (ws.HeaderRect.top == 0) {
// 	// 		return;
// 	// 	}

// 	// 	if (ws.Top > HeaderHeight) {
// 	// 		var dh = prevScrollY - ws.Top;
// 	// 		newTop = ws.HeaderRect.top + dh;
// 	// 	} else {
// 	// 		newTop = ws.Top;
// 	// 	}

// 	// 	if (newTop > 0) {
// 	// 		newTop = 0;
// 	// 	}
// 	// }

// 	// ws.Header.style.top = `${newTop}px`;



// 	prevScrollY = window.scrollY
// }

