var handler;
function InitPayment($public_key)
{
	if (!handler)
	{
		handler = StripeCheckout.configure({
			key: $public_key,
			currency: "EUR"
		});
	}
}
InitPayment(stripePublicKey);

function payment(e)
{
	var target = e.target
	e.preventDefault();

	var formData = new FormData(target);
	if (!formData.get("email"))
	{
		return;
	}
	if (!formData.get("public_key"))
	{
		return;
	}

	if (formData.get("amountCustom"))
	{
		formData.append("amount", formData.get("amountCustom") * 100);
	}

	var amountHandler = parseInt(formData.get("amount"));
	var product = formData.get("product");
	var title = formData.get("title");
	var description = formData.get("description");
	var action = this.action;

	if (amountHandler <= 0)
	{
		handleAjax(action, formData);
		return;
	}

	if (!handler)
	{
		InitPayment(formData.get("public_key"));
	}

	handler.open({
		amount: amountHandler,
		name: title,
		description: description,
		email: formData.get("email"),
		token: function(token) {

			// FormData
			formData.append("token", token.id);

			// Ajax
			handleAjax(action, formData);
		}
	});
}

function handleAjax(action, formData)
{
	// Ajax
	ajax(action, formData, function(xml){
		console.log(xml);
		console.log(xml.innerHTML);
		// What to do with response
		if(xml.getElementsByTagName("error")[0]) // if error
		{
			var errors = xml.getElementsByTagName("error");
			for (var i = errors.length - 1; i >= 0; i--)
			{
				console.log(errors[i].innerHTML);
			}
		}
		else
		{
			location.reload();
		}
	});
}

function setEventToPayments()
{
	// Actual code
	var forms = document.querySelectorAll("form.payment");
	for (var i = 0; i < forms.length; i++)
	{
		forms[i].removeEventListener("submit", payment); // Fix double posting
		forms[i].addEventListener("submit", payment);
	}
}
window.addEventListener("load", setEventToPayments);