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
	var eltxt = obj.getElementsByTagName('span')[0];

	var text = eltxt.innerText;
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


async function _promoter_init(opt) {
	// cek dulu apakah sudah ada elemen buat tampung promoter
	var elms = document.getElementsByClassName('dw-promoter');
	if (elms.length!=1) {
		console.warn(`harus ada 1 elemen dengan class dw-promoters. Dan titemukan ${elms.length} elemen`);
	}
	
	if (typeof opt.onLoad !== 'function') {
		console.warn(`belum ada function onLoad pada option promoter init`);
		obj.classList.remove('hidden');
		return;
	}

	var obj = elms[0]
	var elbtn = obj.getElementsByTagName('button')[0];
	elbtn.onclick = () => {
		obj.classList.add('hidden');
		if (typeof opt.onClose === 'function') {
			opt.onClose ();
		} else {
			console.warn(`belum ada function onClose pada option promoter init`);
		}
	}

	opt.onLoad((text)=>{
		promoter_settext(obj, text)
	})
}


async function promoter_settext(obj, text) {
	console.log(obj);
	console.log(text);

	if (text.length>0) {
		obj.classList.remove('hidden');
		var eltxt = obj.getElementsByTagName('span')[0];
		eltxt.innerHTML = `<span>${text}</span>`
	} else {
		// text kosong, sembunyikan promoter
		obj.classList.add('hidden');
	}
}


