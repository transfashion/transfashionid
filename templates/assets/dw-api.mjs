export async function execute(endpoint, parameters, headers) {
	try {

		var payload = {
			request: parameters
		}

		var respStream = await fetch(endpoint, {
			method: "POST", 
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(payload),
		});
		var result = await respStream.json();

		if (result.code!==0) {
			if (result.errormessage===undefined || result.errormessage==='') {
				console.warn("not expected result from api");
				console.log(result);
				throw new Error('invalid api response from endpoint');
			} else {
				throw new Error(result.errormessage);
			}
		}

		if (result.response===undefined) {
			console.warn("response result is empty");
			console.log(result);
			throw new Error('invalid api response from endpoint');
		}

		return result.response;
	} catch (err) {
		throw err
	}
}