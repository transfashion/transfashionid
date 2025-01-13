const btn_LoginViaWa = document.getElementById('btn_LoginViaWa');
const chk_confirm = document.getElementById('chk_confirm');
const pnl_errormessage = document.getElementById('pnl_errormessage');

const pnl_login_confirmation = document.getElementById('pnl_login_confirmation');
const pnl_login_status = document.getElementById('pnl_login_status');
const txt_whatsapp_message = document.getElementById('txt_whatsapp_message');
const pnl_whatsapp_qrcode = document.getElementById('pnl_whatsapp_qrcode');

const lnks_whatsapp = document.getElementsByClassName('lnk_whatsapp');

let cekCount = 0;

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
	txt_whatsapp_message.innerHTML = '';

	if (!chk_confirm.checked) {
		pnl_errormessage.innerHTML = 'Please confirm that you understand to continue.';
		pnl_errormessage.classList.remove('hidden');
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
		var kalista_sessid = result.kalista_sessid
		if (kalista_sessid===undefined || kalista_sessid=='' || kalista_sessid==null) {
			pnl_errormessage.innerHTML = 'Sorry, something went wrong. Please try again later.';
			pnl_errormessage.classList.remove('hidden');
		}

		var msg = `Hai Transfashion,\nSaya ingin #login-via-whatsapp ke website transfashion.id\n[ref:${kalista_sessid}]`;
		var encodedMsg = encodeURIComponent(msg);
		var phone = window.$global.wa_number;
		var url = `https://api.whatsapp.com/send/?phone=${phone}&text=${encodedMsg}`


		pnl_login_confirmation.classList.add('hidden');
		pnl_login_status.classList.remove('hidden');
		
		var txt = document.createTextNode(msg);
		txt_whatsapp_message.appendChild(txt);

		var canvas = document.createElement('canvas');
		canvas.classList.add('waqrcode');
		pnl_whatsapp_qrcode.appendChild(canvas);

		new QRious({
			element: canvas,
			size: '200',
			value: url,
		});


		console.log(`open whatsapp to login: ${url}`);

		if (isMobile()) {
			window.open(url, '_blank');
		}
		

		// setTimeout(()=>{
		// 	SimulasiCustomerKirimWhatsappLogin(msg);
		// }, 1000);
	
	
		for (var lnk of lnks_whatsapp) {
			lnk.href = url	
			lnk.target = '_blank'
		}

		var autcheck = true;
		if (autcheck) {
			// cek status login di kalista
			cekCount = 0
			let interval = setInterval(async ()=>{
				cekCount++;
				var user = await LoginExternal_GetCustomerLoginSession(kalista_sessid)
				if (user!=null)  {
					clearInterval(interval);
					location.href = '/page/welcome';
				}
			}, 2000)

			// kalau sudah 1 menit, hilangkan waiting spinner
			setTimeout(()=>{
				clearInterval(interval);
				location.href = '/page/login-via-whatsapp?timeout=1';
			}, 1 * 60 * 1000) // 5 menit
		} else {
			// manual cek dengan klik di barcode
			pnl_whatsapp_qrcode.onclick = async () => {
				var user = await LoginExternal_GetCustomerLoginSession(kalista_sessid);
				console.log(user);
				if (user!=null)  {
					location.href = '/page/welcome';
				}
			}
		}
		
  
		
	} catch (err) {
		console.error(err);
	}
}


async function LoginExternal_GetCustomerLoginSession(kalista_sessid) {
	cekCount++;
	var endpoint = '/api/Transfashion/Transfashionid/apis/LoginExternal/GetKalistaCustomerLoginSessionUser'
	var parameter = {
		kalista_sessid: kalista_sessid
	}
	console.log(`cek status login di kalista ${cekCount}`);
	var result = await window.$api.execute(endpoint, parameter);
	return result.user;
}


async function SimulasiCustomerKirimWhatsappLogin(msg) {
	console.log('Simulasi Kirim Whatsapp');
	console.log(msg);

	var parameter = {
		payload: {
			phone_number: "6285885525565",
			message: msg,
			room_id: "57278907",
			from_name: "Agung Nugroho",
			intent: "#login-via-whatsapp"
		}
	}
	var endpoint = '/api/Transfashion/Transfashionid/apis/LoginExternal/SimulasiCustomerKirimWhatsappLogin'
	var result = await window.$api.execute(endpoint, parameter);
	console.log(result)
}

function isMobile() {
	console.log(navigator.userAgent)
	return /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}