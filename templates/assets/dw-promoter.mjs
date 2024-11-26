let reinit_callback = null;

export const Promoter = {
	Init: async (opt) => {
		promoter_init(opt);
	}
}


async function promoter_init(opt) {
	var elms = document.getElementsByClassName('dw-promoter');
	if (elms.length!=1) {
		return;
	}
	
	if (typeof opt.onVisibilityChanged !== 'function') {
		console.warn(`belum ada function onLoad pada option promoter init`);
		obj.classList.remove('hidden');
		return;
	}
	var obj = elms[0]
	var elbtn = obj.getElementsByTagName('button')[0];
	var objcontainer = obj.getElementsByTagName('span')[0];
	var objtext = obj.querySelector('.dw-promoter-text');

	set_promoter_displaymode(objcontainer, objtext);
	if ("orientation" in screen) {
		screen.orientation.addEventListener("change", () => {
			console.log('orientationchange');
			set_promoter_displaymode(objcontainer, objtext);
		});
	} 

	var text = objtext.innerText;
	if (text.length>0) {
		obj.classList.remove('hidden');
		elbtn.onclick = () => {
			obj.classList.add('hidden');
			opt.onVisibilityChanged();
		}
	} else {
		obj.classList.add('hidden');
	}

	opt.onVisibilityChanged();
}


function set_promoter_displaymode(objcontainer,objtext) {
	var containerRect = objcontainer.getBoundingClientRect();
	var containerWidth = containerRect.right - containerRect.left;
	
	var textRect = objtext.getBoundingClientRect();
	var textWidth = textRect.right - textRect.left;

	if (textWidth>containerWidth) {
		// running text
		objcontainer.classList.remove('dw-promoter-center')
		objcontainer.classList.add('dw-promoter-left')
		objtext.classList.remove('dw-promoter-blinking')
		objtext.classList.add('dw-promoter-running')
	} else {
		// blinking
		objcontainer.classList.remove('dw-promoter-left')
		objcontainer.classList.add('dw-promoter-center')
		objtext.classList.remove('dw-promoter-running')
		objtext.classList.add('dw-promoter-blinking')
	}

}


