const btn_LoginViaWa = document.getElementById('btn_LoginViaWa');
const chk_confirm = document.getElementById('chk_confirm');
const pnl_unconfirm = document.getElementById('pnl_unconfirm');

export async function Init() {
	console.log('Login via whatsapp Init');


	btn_LoginViaWa.addEventListener('click', () => {
		btn_LoginViaWa_click();
	});

	chk_confirm.addEventListener('click', ()=>{
		chk_confirm_click();
	})
}


function chk_confirm_click() {
	if (!chk_confirm.checked) {
		btn_LoginViaWa.disabled = true
	} else {
		btn_LoginViaWa.disabled = false
	}
}

async function btn_LoginViaWa_click() {
	if (!chk_confirm.checked) {
		pnl_unconfirm.classList.add('hidden');
		return;
	}

	// daftarkan session id ke kalista
	var sessid = chk_confirm.value
	var endpoint = '/api/Transfashion/Transfashionid/apis/LoginExternal/RegisterKalistaSession'
	var parameter = {
		sessid: sessid
	}
	
	try {
		var result = await window.$api.execute(endpoint, parameter);
		console.log(result);

	} catch (err) {
		console.error(err);
	}


	
	
	// var msg = `Hai Transfashion,\nSaya ingin #login-website-transfashion via whatsapp\n[ref:${sessid}]`;
	// var encodedMsg = encodeURIComponent(msg);
	// var phone = window.$global.wa_number;
	// var url = `https://api.whatsapp.com/send/?phone=${phone}&text=${encodedMsg}`

	// window.open(url, '_blank');
}