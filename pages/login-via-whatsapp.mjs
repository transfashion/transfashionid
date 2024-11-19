const btn_LoginViaWa = document.getElementById('btn_LoginViaWa');
const chk_confirm = document.getElementById('chk_confirm');
const pnl_unconfirm = document.getElementById('pnl_unconfirm');

export async function Init() {
	console.log('Login via whatsapp Init');


	btn_LoginViaWa.addEventListener('click', () => {
		btnLoginViaWa_click();
	});

	chk_confirm.addEventListener('click', ()=>{
		chk_confirm_click();
	})
}


function btnLoginViaWa_click() {
	console.log('click')
	if (!chk_confirm.checked) {
		pnl_unconfirm.classList.add('hidden');
		return;
	}
}

function chk_confirm_click() {
	if (!chk_confirm.checked) {
		btn_LoginViaWa.disabled = true
	} else {
		btn_LoginViaWa.disabled = false
	}
}