

export async function Promoter(params, fn_callback) {
	// cek dulu apakah sudah ada elemen buat tampung promoter
	var elms = document.getElementsByClassName('dw-promoter');
	if (elms.length!=1) {
		console.warn(`harus ada 1 elemen dengan class dw-promoters. Dan titemukan ${elms.length} elemen`);
	}
	
	var obj = elms[0]
	var info = await getCurrentPromoterInfo(params);
	if (info==null) {
		obj.classList.add('hidden');
	} else {
		obj.classList.remove('hidden');
		var eltxt = obj.getElementsByTagName('span')[0];
		eltxt.innerHTML = `<span>${info.text}</span>`

		var elbtn = obj.getElementsByTagName('button')[0];
		elbtn.onclick = () => {
			obj.classList.add('hidden');
		}
	}

	fn_callback(info);	
}



async function getCurrentPromoterInfo(params) {
	var result = {
		text: 'Dapatkan tambahan discount <b>50%</b> setiap pembelian 2 pairs di <b>GEOX Kota Casablanca</b>, berlaku <b>hanya hari ini</b> Rabu, 13 November 2024.'
	}
	return result;
}
